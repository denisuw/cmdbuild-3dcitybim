#!/bin/bash

cmdbuild_dir=~/svn/cmdbuild_25/
r2u_dir=~/svn/cmdbuild-ready2use_25/
openmaint_dir=~/svn/cmdbuild-openmaint_25/

long_date=$(date +%Y-%m-%d_%H-%M)
short_date=$(date +%Y%m%d%H%M)
label_date=$(date +%Y-%m-%d)

for dir in "$cmdbuild_dir" "$r2u_dir" "$openmaint_dir"; do
	cd "$dir"
	echo "check $(basename "$dir")"
	if [ -e .hg ]; then
		hg pull -u
		hg status
	else
		git pull
		git status
	fi
	echo
done

echo -n "continue? "
read

cd "$cmdbuild_dir"

cmdbuild_ver="$(sed -n -r 's#.*[<]cmdbuild.version[>]([^<]+)[<]/cmdbuild.version[>].*#\1#p' parent/pom.xml  | head -n1)"
base_ver="$(echo "$cmdbuild_ver" | sed 's#-[a-z]##')"
suffix="${cmdbuild_ver}-${short_date}"
label="${cmdbuild_ver} (${label_date})"

mvn clean install -Dmaven.test.skip -am -pl cmdbuild,shark/server || exit 1

cmdbuild_temp=$(mktemp -d)

cmdbuildwar=$(ls cmdbuild/target/*.war)
sharkwar=$(ls shark/server/target/*.war)

cp "$cmdbuildwar" "$cmdbuild_temp/cmdbuild-${suffix}.war"
cp "$sharkwar" "$cmdbuild_temp/shark-${suffix}.war"

set_version_label_in_translations.sh "$label" $cmdbuild_temp/cmdbuild*war || exit 1

r2u_temp=$(mktemp -d)

pushd "$r2u_dir"
pushd cmdbuild/overlay/cmdbuild/
r2u_version="$(sed -n -r 's#.*[<]ready2use.version[>]([^<]+)[<]/ready2use.version[>].*#\1#p' pom.xml)"
r2u_suffix="${r2u_version}-${suffix}"
mvn clean install || exit 1
cp target/*.war "$r2u_temp/cmdbuild-ready2use-${r2u_suffix}.war"
popd
pushd cmdbuild/overlay/cmdbuild-shark-server
mvn clean install || exit 1
cp target/*.war "$r2u_temp/shark-ready2use-${r2u_suffix}.war"
popd
popd

delete_files_from_war.sh $r2u_temp/cmdbuild*war WEB-INF/patches-ext || exit 1
set_version_label_in_translations.sh "$label" $r2u_temp/cmdbuild*war || exit 1

openmaint_temp=$(mktemp -d)

pushd "$openmaint_dir"
pushd cmdbuild/overlay/cmdbuild/
openmaint_version="$(sed -n -r 's#.*[<]openmaint.version[>]([^<]+)[<]/openmaint.version[>].*#\1#p' pom.xml)"
openmaint_suffix="${openmaint_version}-${suffix}"
mvn clean install || exit 1
cp target/*.war "$openmaint_temp/cmdbuild-openmaint-${openmaint_suffix}.war"
popd
pushd cmdbuild/overlay/cmdbuild-shark-server
mvn clean install || exit 1
cp target/*.war "$openmaint_temp/shark-openmaint-${openmaint_suffix}.war"
popd
popd

delete_files_from_war.sh $openmaint_temp/cmdbuild*war WEB-INF/patches-ext || exit 1
set_version_label_in_translations.sh "$label" $openmaint_temp/cmdbuild*war || exit 1

echo
du -sh $cmdbuild_temp/* $r2u_temp/* $openmaint_temp/*
#echo -n "ready to release. proceed? "
#read

echo "copy to share"

deploy_to_local_share.sh "/srv/samba/cmdbuild/Release/CMDBuild/${base_ver}/${suffix}" $cmdbuild_temp/*
deploy_to_local_share.sh "/srv/samba/cmdbuild/Ready2Use/Release/CMDBuild/${r2u_version}-${base_ver}/${r2u_suffix}" $r2u_temp/*
deploy_to_local_share.sh "/srv/samba/openmaint/Release/${openmaint_version}-${base_ver}/${openmaint_suffix}" $openmaint_temp/*

echo "upload to dropbox"

uploader=~/svn/Dropbox-Uploader/dropbox_uploader.sh

$uploader mkdir "Public/CMDBuild/release/${suffix}"
$uploader upload $cmdbuild_temp/* "Public/CMDBuild/release/${suffix}"
$uploader mkdir "Public/CMDBuild/Ready2Use/release/${r2u_suffix}"
$uploader upload $r2u_temp/* "Public/CMDBuild/Ready2Use/release/${r2u_suffix}"
$uploader mkdir "Public/openMAINT/release/${openmaint_suffix}"
$uploader upload $openmaint_temp/* "Public/openMAINT/release/${openmaint_suffix}"

echo "done!"

rm -r $cmdbuild_temp $r2u_temp $openmaint_temp


