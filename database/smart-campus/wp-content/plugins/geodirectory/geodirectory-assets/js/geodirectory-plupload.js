jQuery.fn.exists = function () {
    return jQuery(this).length > 0;
}

jQuery(document).ready(function ($) {
    if ($(".plupload-upload-uic").exists()) {
        var pconfig = false;
        var msgErr = '';

        $(".plupload-upload-uic").each(function () {
            var $this = $(this);
            var id1 = $this.attr("id");
            var imgId = id1.replace("plupload-upload-ui", "");

            plu_show_thumbs(imgId);

            pconfig = JSON.parse(gd_plupload.base_plupload_config);
            pconfig["browse_button"] = imgId + pconfig["browse_button"];
            pconfig["container"] = imgId + pconfig["container"];
            if(pconfig["drop_element"]){ pconfig["drop_element"] = imgId + pconfig["drop_element"];} // only add drop area if there is one
            pconfig["file_data_name"] = imgId + pconfig["file_data_name"];
            pconfig["multipart_params"]["imgid"] = imgId;
            pconfig["multipart_params"]["_ajax_nonce"] = $this.find(".ajaxnonceplu").attr("id").replace("ajaxnonceplu", "");

            if ($this.hasClass("plupload-upload-uic-multiple")) {
                pconfig["multi_selection"] = true;
            }

            if ($this.find(".plupload-resize").exists()) {
                var w = parseInt($this.find(".plupload-width").attr("id").replace("plupload-width", ""));
                var h = parseInt($this.find(".plupload-height").attr("id").replace("plupload-height", ""));
                pconfig["resize"] = {
                    width: w,
                    height: h,
                    quality: 90
                };
            }
			var allowed_exts = jQuery('#' + imgId + '_allowed_types').val();
			allowed_exts = allowed_exts && allowed_exts != '' ? allowed_exts : '';
			if (imgId == 'post_images' && typeof geodir_all_js_msg.gd_allowed_img_types != 'undefined' && geodir_all_js_msg.gd_allowed_img_types != '') {
				allowed_exts = geodir_all_js_msg.gd_allowed_img_types;
			}

			if (allowed_exts && allowed_exts != '') {
				var txt_all_files = (typeof geodir_all_js_msg.geodir_txt_all_files != 'undefined' && geodir_all_js_msg.geodir_txt_all_files != '') ? geodir_all_js_msg.geodir_txt_all_files : 'Allowed files';
				pconfig['filters'] = [{'title':txt_all_files, 'extensions':allowed_exts}];
			}

            var uploader = new plupload.Uploader(pconfig);
            uploader.bind('Init', function (up) {
                //alert(1);
            });
            uploader.init();
            uploader.bind('Error', function (up, files) {
                if (files.code == -600) {
                    jQuery('#' + imgId + 'upload-error').addClass('upload-error');

                    if (typeof geodir_all_js_msg.geodir_err_max_file_size != 'undefined' && geodir_all_js_msg.geodir_err_max_file_size != '') {
                        msgErr = geodir_all_js_msg.geodir_err_max_file_size;
                    } else {
                        msgErr = 'File size error : You tried to upload a file over %s';
                    }
                    msgErr = msgErr.replace("%s", gd_plupload.upload_img_size);

                    jQuery('#' + imgId + 'upload-error').html(msgErr);
                } else if (files.code == -601) {
                    jQuery('#' + imgId + 'upload-error').addClass('upload-error');

                    if (typeof geodir_all_js_msg.geodir_err_file_type != 'undefined' && geodir_all_js_msg.geodir_err_file_type != '') {
                        msgErr = geodir_all_js_msg.geodir_err_file_type;
                    } else {
                        msgErr = 'File type error. Allowed file types: %s';
                    }
					if(imgId == 'post_images') {
						var txtReplace = allowed_exts != '' ? "." + allowed_exts.replace(/,/g, ", .") : '*';
						msgErr = msgErr.replace("%s", txtReplace);
					} else {
						msgErr = msgErr.replace("%s", jQuery("#" + imgId + "_allowed_types").attr('data-exts'));
					}

                    jQuery('#' + imgId + 'upload-error').html(msgErr);
                } else {
                    jQuery('#' + imgId + 'upload-error').addClass('upload-error');
                    jQuery('#' + imgId + 'upload-error').html(files.message);
                }
            });
            totalImg = jQuery("#" + imgId + "totImg").val();
            limitImg = jQuery("#" + imgId + "image_limit").val();

            //a file was added in the queue
            //totalImg = gd_plupload.totalImg;
            //limitImg = gd_plupload.image_limit;
            uploader.bind('FilesAdded', function (up, files) {
                jQuery('#' + imgId + 'upload-error').html('');
                jQuery('#' + imgId + 'upload-error').removeClass('upload-error');

                if (limitImg && $this.hasClass("plupload-upload-uic-multiple") && jQuery("#" + imgId + "image_limit").val()) {
                    if (totalImg == limitImg && parseInt(limitImg) > 0) {
                        while (up.files.length > 0) {
                            up.removeFile(up.files[0]);
                        } // remove images

                        if (typeof geodir_all_js_msg.geodir_err_file_upload_limit != 'undefined' && geodir_all_js_msg.geodir_err_file_upload_limit != '') {
                            msgErr = geodir_all_js_msg.geodir_err_file_upload_limit;
                        } else {
                            msgErr = 'You have reached your upload limit of %s files.';
                        }
                        msgErr = msgErr.replace("%s", limitImg);

                        jQuery('#' + imgId + 'upload-error').addClass('upload-error');

                        jQuery('#' + imgId + 'upload-error').html(msgErr);
                        return false;
                    }

                    if (up.files.length > limitImg && parseInt(limitImg) > 0) {
                        while (up.files.length > 0) {
                            up.removeFile(up.files[0]);
                        } // remove images

                        if (typeof geodir_all_js_msg.geodir_err_pkg_upload_limit != 'undefined' && geodir_all_js_msg.geodir_err_pkg_upload_limit != '') {
                            msgErr = geodir_all_js_msg.geodir_err_pkg_upload_limit;
                        } else {
                            msgErr = 'You may only upload %s files with this package, please try again.';
                        }
                        msgErr = msgErr.replace("%s", limitImg);

                        jQuery('#' + imgId + 'upload-error').addClass('upload-error');
                        jQuery('#' + imgId + 'upload-error').html(msgErr);
                        return false;
                    }

                    /*if((parseInt(up.files.length)+parseInt(totalImg)>parseInt(limitImg)) && parseInt(limitImg) > 0){
                     while(up.files.length > 0) {up.removeFile(up.files[0]);} // remove images
                     jQuery('#'+imgId+'upload-error').addClass('upload-error');
                     jQuery('#'+imgId+'upload-error').html('You may only upload another '+(parseInt(limitImg)-parseInt(totalImg))+' with this package, please try again.');
                     return false;
                     }*/
                }

                $.each(files, function (i, file) {
                    $this.find('.filelist').append('<div class="file" id="' + file.id + '"><b>' + file.name + '</b> (<span>' + plupload.formatSize(0) + '</span>/' + plupload.formatSize(file.size) + ') ' + '<div class="fileprogress"></div></div>');
                });

                up.refresh();
                up.start();
            });

            uploader.bind('UploadProgress', function (up, file) {
                $('#' + file.id + " .fileprogress").width(file.percent + "%");
                $('#' + file.id + " span").html(plupload.formatSize(parseInt(file.size * file.percent / 100)));
            });

            var timer;
            var i = 0;
            var indexes = new Array();
            uploader.bind('FileUploaded', function (up, file, response) {
                //totalImg++;
                //up.removeFile(up.files[0]); // remove images
                indexes[i] = up;
                clearInterval(timer);
                timer = setTimeout(function () {
                    //geodir_remove_file_index(indexes);
                }, 1000);
                i++;
                $('#' + file.id).fadeOut();
                response = response["response"];
                // add url to the hidden field
                if ($this.hasClass("plupload-upload-uic-multiple")) {
                    totalImg++;
                    // multiple
                    var v1 = $.trim($("#" + imgId).val());
                    if (v1) {
                        v1 = v1 + "," + response;
                    } else {
                        v1 = response;
                    }
                    $("#" + imgId).val(v1);
                } else {
                    // single
                    $("#" + imgId).val(response + "");
                }
                // show thumbs
                plu_show_thumbs(imgId);
            });
        });
    }
});

function geodir_remove_file_index(indexes) {
    for (var i = 0; i < indexes.length; i++) {
        if (indexes[i].files.length > 0) {
            indexes[i].removeFile(indexes[i].files[0]);
        }
    }
}

function plu_show_thumbs(imgId) {
    var $ = jQuery;
    var thumbsC = $("#" + imgId + "plupload-thumbs");
    thumbsC.html("");
    // get urls
    var imagesS = $("#" + imgId).val();

    var txtRemove = 'Remove';
    if (typeof geodir_all_js_msg.geodir_action_remove != 'undefined' && geodir_all_js_msg.geodir_action_remove != '') {
        txtRemove = geodir_all_js_msg.geodir_action_remove;
    }

    var images = imagesS.split(",");

    for (var i = 0; i < images.length; i++) {
        if (images[i] && images[i] != 'null') {
            var file_ext = images[i].substring(images[i].lastIndexOf('.') + 1);
            file_ext = file_ext.split('?').shift();// in case the image url has params
            var fileNameIndex = images[i].lastIndexOf("/") + 1;
            var dotIndex = images[i].lastIndexOf('.');
            if(dotIndex < fileNameIndex){continue;}
            var file_name = images[i].substr(fileNameIndex, dotIndex < fileNameIndex ? loc.length : dotIndex);

            /*if (file_ext == 'pdf' || file_ext == 'xlsx' || file_ext == 'xls' || file_ext == 'csv' || file_ext == 'docx' || file_ext == 'doc' || file_ext == 'txt') {
                file_name = file_name.split(imgId + '_');
                var thumb = $('<div class="thumb geodir_file" id="thumb' + imgId + i + '"><div class="thumbi"><a id="thumbremovelink' + imgId + i + '" href="#">' + txtRemove + '</a></div><a target="_blank" href="' + images[i] + '">' + file_name[file_name.length - 1] + '</a></div>');
            } else {
                var thumb = $('<div class="thumb" id="thumb' + imgId + i + '"><div class="thumbi"><a id="thumbremovelink' + imgId + i + '" href="#">' + txtRemove + '</a></div><img src="' + images[i] + '" alt=""  /></div>');
            }*/
			if (file_ext == 'jpg' || file_ext == 'jpe' || file_ext == 'jpeg' || file_ext == 'png' || file_ext == 'gif' || file_ext == 'bmp' || file_ext == 'ico') {
                var thumb = $('<div class="thumb" id="thumb' + imgId + i + '"><div class="thumbi"><a id="thumbremovelink' + imgId + i + '" href="#">' + txtRemove + '</a></div><img src="' + images[i] + '" alt=""  /></div>');
            } else {
                file_name = file_name.split(imgId + '_');
                var thumb = $('<div class="thumb geodir_file" id="thumb' + imgId + i + '"><div class="thumbi"><a id="thumbremovelink' + imgId + i + '" href="#">' + txtRemove + '</a></div><a target="_blank" href="' + images[i] + '">' + file_name[file_name.length - 1] + '</a></div>');
            }

            thumbsC.append(thumb);

            thumb.find("a", "thumbi").click(function () {
                if (jQuery('#' + imgId + 'plupload-upload-ui').hasClass("plupload-upload-uic-multiple")) totalImg--; // remove image from total
                jQuery('#' + imgId + 'upload-error').html('');
                jQuery('#' + imgId + 'upload-error').removeClass('upload-error');
                var ki = $(this).attr("id").replace("thumbremovelink" + imgId, "");
                ki = parseInt(ki);
                var kimages = [];
                imagesS = $("#" + imgId).val();
                images = imagesS.split(",");
                for (var j = 0; j < images.length; j++) {
                    if (j != ki) {
                        kimages[kimages.length] = images[j];
                    }
                }
                $("#" + imgId).val(kimages.join());
                plu_show_thumbs(imgId);
                return false;
            });
        }
    }

    if (images.length > 1) {
        thumbsC.sortable({
            update: function (event, ui) {
                var kimages = [];
                thumbsC.find("img").each(function () {
                    kimages[kimages.length] = $(this).attr("src");
                    $("#" + imgId).val(kimages.join());
                    plu_show_thumbs(imgId);
                });
            }
        });
        thumbsC.disableSelection();
    }
}