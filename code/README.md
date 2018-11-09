fungsi readGeoFeatures ada di GeoFeatureStore.java (services\gis)
fungsi getFeatures ada di DefaultGISLogic.java (logic) manggil fungsi geoFeatureStore.readGeoFeatures(layerMetaData, bbox);
fungsi getGeoCardList ada di Gis.java (servlets\json) manggil fungsi logic.getFeatures(masterClassName, layerName, bbox)
fungsi readGeoFeatures ada di GeoFeatureStore.java (services\gis) manggil fungsi readGeoFeaturesQuery(layerMetaData, bbox ), 

#CMDBuild re-code
(Management.js)
Call sequence: init() -> buildConfiguration() -> buildCache() -> buildUserInterface() -> 
               CMModCard.theMap = Ext.create('CMDBuild.view.management.classes.map.CMMapPanel'
               in CMMapPanel : this.mapPanel = Ext.create('CMDBuild.Management.CMMap'
               CMMap extend from Map
entwine cesium
Map
CMMap extend Map
CMMapPanel have an atribut mapPanel : CMMap
InteractionDocuemtn

cmmappanel.js UI interface

ModExternalServices.js C:\Tomcat8\webapps\cmdbuild\javascripts\cmdbuild\view\administration\gis
ExternalServices.js C:\Tomcat8\webapps\cmdbuild\javascripts\cmdbuild\view\administration\gis
Proxy.js C:\Tomcat8\webapps\cmdbuild\javascripts\cmdbuild\core\constants
Gis.js C:\Tomcat8\webapps\cmdbuild\javascripts\cmdbuild\model\core\configuration\builder\gis
Osm.js or Arcgis.js C:\Tomcat8\webapps\cmdbuild\javascripts\cmdbuild\model\core\configuration\builder\gisf
CMDBuildGeoExt.js C:\Tomcat8\webapps\cmdbuild\javascripts\cmdbuild\view\management\classes\map\geoextension
Map.js C:\Tomcat8\webapps\cmdbuild\javascripts\cmdbuild\view\management\classes\map\geoextension

https://bitbucket.org/tecnoteca/cmdbuild/wiki/Home
mvn clean install
http://www.cmdbuild.org/forum/forum-in-english/418505290?set_language=en&cl=en

https://helpcenter.graphisoft.com/tips/open-bim/survey-point-is-now-supported-at-ifc-importexport/

instalasi openmaint
1. shark.conf
org.cmdbuild.ws.url=http://localhost:8080/openmaint/
2. context.xml (shark/meta-inf)
url="jdbc:postgresql://localhost:5434/openmaint" (database name)

SET SEARCH_PATH TO gis, public;
ALTER DATABASE "openmaint-itb" SET search_path="postgres", public, gis;

ALTER ROLE shark SET search_path=pg_default,shark; 

Bimserver 1.5.81.
BIMServer JavaScript API 0.0.120
BIMsurfer 0.0.41
BIMvie.ws 0.0.85
BinarySerializers 0.0.26
Console 0.0.10
IfcOpenShellPlugin 0.5.24
IfcPlugins 0.0.30

For your reference, (GeoServer 2.11.0 is installed)

1. Open your shape file in QGIS (ArcGIS) and check the geolocation
2. Set the CRS to EPSG:3857, save as shape file
3. Zip (not 7-Zip) all shape files
4. Import the Zip (shape) file through CMDBuild (OpenMaint), the file name MUST as same as the layer name (its work for me).
5. Layer preview in GeoServer, if fail please return to step 1
6. follow the instruction which in the reply of CMDBuild Team.

CREATE OR REPLACE FUNCTION gis.astext(geometry)
  RETURNS text AS
'$libdir/postgis-2.2', 'LWGEOM_asText'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;
ALTER FUNCTION gis.astext(geometry)
  OWNER TO postgres;

C:\Tomcat8\webapps\cmdbuild\javascripts\cmdbuild\view\management\classes\map\geoextension

./javascripts/cmdbuild/view/management/classes/map/navigationTree/Cache.js:41

UPDATE "lahanparkir"
SET "Id" = "Parking"."Id"
FROM "Parking" WHERE ("lahanparkir".id_parkir = "Parking"."Code");

UPDATE "Detail_Building_the_geom"
SET "Geometry" = st_transform("gedung-simple".geom,900913)
FROM "gedung-simple"
WHERE ("Detail_Building_the_geom"."Master" = "gedung-simple"."Id");

INSERT INTO "Detail_Building_the_geom" ("IdClass", "Master", "Geometry")
(SELECT '"Detail_Building_the_geom"', "Id",  st_transform(geom,900913) FROM "gedung-simple");

UPDATE "lahanparkir"
SET id = "Parking"."Id"
FROM "Parking" WHERE ("lahanparkir".id_parkir = CAST(coalesce("Parking"."Code", '0') AS integer));

INSERT INTO "Detail_Parking_the_geom" ("IdClass", "Master", "Geometry")
(SELECT '"Detail_Parking_the_geom"', id,  st_transform(geom,900913) FROM "lahanparkir");

UPDATE "asjalan" SET id = "RoadNetwork"."Id"
FROM "RoadNetwork" WHERE ("asjalan".code = "RoadNetwork"."Code");


INSERT INTO "Detail_Room_the_geom" ("IdClass", "Master", "Geometry")
(SELECT '"Detail_Room_the_geom"', "room_id",  st_transform(geom,900913) FROM "ruangan" WHERE "ruangan".kode_lantai='138-B1');

UPDATE "ruangan"
SET "room_id" = "Room"."Id" from "Room"
WHERE ("ruangan".kode_ruang = "Room"."Code") and (kode_gedung = '136');

update ruangan set kode_ruang = kode_lantai || '-' || trim(leading ' ' from to_char(id,'00000')) 


select kode_ruang, kode_lantai, kode_gedung, kode_complex, uraian,  kode_ruang from ruangan 
where kode_gedung ='163' 
select distinct kode_lantai, kode_gedung, kode_complex from ruangan 
where kode_gedung ='163' 
