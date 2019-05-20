<?php
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

if (!function_exists('petakampus_get_images')) {
	function petakampus_get_images()
	{
		global $wpdb;
		if ($limit) {
            $limit_q = " LIMIT $limit ";
        } else {
            $limit_q = '';
        }
        $sub_dir = '';
        $not_featured = " AND is_featured = 0 ";
			
		$arrImages = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM " . GEODIR_ATTACHMENT_TABLE ,
                array('%image%')
            )
        );	

		$counter = 0;
        $return_arr = array();

        if (!empty($arrImages)) {
            foreach ($arrImages as $attechment) {
                $img_arr = array();
                $img_arr['id'] = $attechment->ID;
                $img_arr['user_id'] = isset($attechment->user_id) ? $attechment->user_id : 0;

                $file_info = pathinfo($attechment->file);

                if ($file_info['dirname'] != '.' && $file_info['dirname'] != '..')
                    $sub_dir = stripslashes_deep($file_info['dirname']);

                $uploads = wp_upload_dir(trim($sub_dir, '/')); // Array of key => value pairs
                $uploads_baseurl = $uploads['baseurl'];
                $uploads_path = $uploads['path'];

                $file_name = $file_info['basename'];

                $uploads_url = $uploads_baseurl . $sub_dir;
                /*
                * Allows the filter of image src for such things as CDN change.
                *
                * @since 1.5.7
                * @param string $url The full image url.
                * @param string $file_name The image file name and directory path.
                * @param string $uploads_url The server upload directory url.
                * @param string $uploads_baseurl The uploads dir base url.
                */
                $img_arr['src'] = apply_filters('geodir_get_images_src',$uploads_url . '/' . $file_name,$file_name,$uploads_url,$uploads_baseurl);
                $img_arr['path'] = $uploads_path . '/' . $file_name;
                $width = 0;
                $height = 0;
                if (is_file($img_arr['path']) && file_exists($img_arr['path'])) {
                    $imagesize = getimagesize($img_arr['path']);
                    $width = !empty($imagesize) && isset($imagesize[0]) ? $imagesize[0] : '';
                    $height = !empty($imagesize) && isset($imagesize[1]) ? $imagesize[1] : '';
                }
                $img_arr['width'] = $width;
                $img_arr['height'] = $height;

                $img_arr['file'] = $file_name; // add the title to the array
                $img_arr['title'] = $attechment->title; // add the title to the array
                $img_arr['caption'] = isset($attechment->caption) ? $attechment->caption : ''; // add the caption to the array
                $img_arr['content'] = $attechment->content; // add the description to the array
                $img_arr['is_approved'] = isset($attechment->is_approved) ? $attechment->is_approved : ''; // used for user image moderation. For backward compatibility Default value is 1.

                $return_arr[] = (object)$img_arr;
				
			//	echo ($img_arr['src']);

                $counter++;
            }
            //return (object)$return_arr;
			//return $return_arr;
            /**
             * Filter the images array so things can be changed.
             *
             * @since 1.6.20
             * @param array $return_arr The array of image objects.
             */
            return apply_filters('geodir_get_images_arr',$return_arr);
			//return apply_filters('',$return_arr);
        }
	}
}

if (!function_exists('petakampus_get_images_geo')) {
	function petakampus_get_images_geo()
	{
		global $wpdb;
		if ($limit) {
            $limit_q = " LIMIT $limit ";
        } else {
            $limit_q = '';
        }
        $sub_dir = '';
        $not_featured = " AND is_featured = 0 ";
			
		$arrImages = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM wp_geodir_gd_place_detail" ,
                array('%image%')
            )
        );	

		$counter = 0;
        $return_arr = array();

        if (!empty($arrImages)) {
            foreach ($arrImages as $attechment) {
                $img_arr = array();
                $img_arr['id'] = $attechment->post_id;


                $file_info = pathinfo($attechment->featured_image);

                if ($file_info['dirname'] != '.' && $file_info['dirname'] != '..')
                    $sub_dir = stripslashes_deep($file_info['dirname']);

                $uploads = wp_upload_dir(trim($sub_dir, '/')); // Array of key => value pairs
                $uploads_baseurl = $uploads['baseurl'];
                $uploads_path = $uploads['path'];

                $file_name = $file_info['basename'];

                $uploads_url = $uploads_baseurl . $sub_dir;
                /*
                * Allows the filter of image src for such things as CDN change.
                *
                * @since 1.5.7
                * @param string $url The full image url.
                * @param string $file_name The image file name and directory path.
                * @param string $uploads_url The server upload directory url.
                * @param string $uploads_baseurl The uploads dir base url.
                */
                $img_arr['src'] = apply_filters('geodir_get_images_src',$uploads_url . '/' . $file_name,$file_name,$uploads_url,$uploads_baseurl);
                $img_arr['path'] = $uploads_path . '/' . $file_name;
                $width = 0;
                $height = 0;
                if (is_file($img_arr['path']) && file_exists($img_arr['path'])) {
                    $imagesize = getimagesize($img_arr['path']);
                    $width = !empty($imagesize) && isset($imagesize[0]) ? $imagesize[0] : '';
                    $height = !empty($imagesize) && isset($imagesize[1]) ? $imagesize[1] : '';
                }
                $img_arr['width'] = $width;
                $img_arr['height'] = $height;

                $img_arr['file'] = $file_name; // add the title to the array
                $img_arr['title'] = $attechment->post_title; // add the title to the array
                $img_arr['caption'] = isset($attechment->post_title) ? $attechment->post_title : ''; // add the caption to the array
                $img_arr['latitude'] = $attechment->post_latitude; // 
                $img_arr['longitude'] = $attechment->post_longitude;// .

                $return_arr[] = (object)$img_arr;
				
			//	echo ($img_arr['src']);

                $counter++;
            }
            //return (object)$return_arr;
			//return $return_arr;
            /**
             * Filter the images array so things can be changed.
             *
             * @since 1.6.20
             * @param array $return_arr The array of image objects.
             */
            return apply_filters('geodir_get_images_arr',$return_arr);
			//return apply_filters('',$return_arr);
        }
	}
}

?>