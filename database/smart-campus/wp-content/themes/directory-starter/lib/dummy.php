<?php
// Dummy data functions
function dt_geodir_dummy_folder_exists($folder_name)
{
	$path = get_stylesheet_directory() . '/'.$folder_name.'/dummy/';
	if (!is_dir($path))
		return false;
	else
		return true;

}

function dt_geodir_insert_dummy_posts($post_type, $categories, $folder_name)
{
	dt_geodir_default_taxonomies($post_type, $categories, $folder_name);

	global $wpdb, $current_user;

	include_once(get_stylesheet_directory() . '/'.$folder_name.'/dummy/dummy_content.php');
}

function dt_geodir_delete_dummy_posts($post_type){

	global $wpdb, $plugin_prefix;
	$detail_table = $plugin_prefix .$post_type.'_detail';

	$post_ids = $wpdb->get_results("SELECT post_id FROM ".$detail_table." WHERE post_dummy='1'");

	foreach($post_ids as $post_ids_obj)
	{
		wp_delete_post($post_ids_obj->post_id);
	}

	//double check posts are deleted
	$wpdb->get_results("DELETE FROM ".$detail_table." WHERE post_dummy='1'");
}

function dt_geodir_default_taxonomies($post_type, $categories, $folder_name)
{

	global $wpdb, $dummy_image_path;
    $cat_count = count($categories);
	for ($i = 0; $i < $cat_count; $i++) {
		$parent_catid = 0;
		if (is_array($categories[$i])) {
			$cat_name_arr = $categories[$i];
            $count_cat_name_arr = count($cat_name_arr);
			for ($j = 0; $j < $count_cat_name_arr; $j++) {
				$catname = $cat_name_arr[$j];

				if (!term_exists($catname, $post_type.'category')) {
					$last_catid = wp_insert_term($catname, $post_type.'category', $args = array('parent' => $parent_catid));

					if ($j == 0) {
						$parent_catid = $last_catid;
					}

					dt_geodir_insert_taxonomy($post_type, $catname, $folder_name, $last_catid);
				}
			}

		} else {
			$catname = $categories[$i];

			if (!term_exists($catname, $post_type.'category')) {
				$last_catid = wp_insert_term($catname, $post_type.'category');

				dt_geodir_insert_taxonomy($post_type, $catname, $folder_name, $last_catid);
			}
		}

	}
}

function dt_geodir_insert_taxonomy($post_type, $catname, $folder_name, $last_catid) {

	$uploads = wp_upload_dir(); // Array of key => value pairs

	$dummy_image_url = get_template_directory_uri() . "/assets/images";

	$uploaded = (array)fetch_remote_file("$dummy_image_url/cat_icon.png");

	$new_path = null;
	$new_url = null;
	if (empty($uploaded['error'])) {
		$new_path = $uploaded['file'];
		$new_url = $uploaded['url'];
	}

	$wp_filetype = wp_check_filetype(basename($new_path), null);

	$attachment = array(
		'guid' => $uploads['baseurl'] . '/' . basename($new_path),
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => preg_replace('/\.[^.]+$/', '', basename($new_path)),
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attach_id = wp_insert_attachment($attachment, $new_path);

	// you must first include the image.php file
	// for the function wp_generate_attachment_metadata() to work
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	$attach_data = wp_generate_attachment_metadata($attach_id, $new_path);
	wp_update_attachment_metadata($attach_id, $attach_data);

	if (!geodir_get_tax_meta($last_catid['term_id'], 'ct_cat_icon', false, $post_type)) {
		geodir_update_tax_meta($last_catid['term_id'], 'ct_cat_icon', array('id' => 'icon', 'src' => $new_url), $post_type);
	}
}

function dt_geodir_dummy_content_generator($post_infos = array()) {
	global $city_bound_lat1, $city_bound_lng1, $city_bound_lat2, $city_bound_lng2;

	if (empty($post_infos)) {
		return;
	}

	foreach ($post_infos as $post_info) {
		$default_location = geodir_get_default_location();
		if ($city_bound_lat1 > $city_bound_lat2)
			$dummy_post_latitude = geodir_random_float(geodir_random_float($city_bound_lat1, $city_bound_lat2), geodir_random_float($city_bound_lat2, $city_bound_lat1));
		else
			$dummy_post_latitude = geodir_random_float(geodir_random_float($city_bound_lat2, $city_bound_lat1), geodir_random_float($city_bound_lat1, $city_bound_lat2));


		if ($city_bound_lng1 > $city_bound_lng2)
			$dummy_post_longitude = geodir_random_float(geodir_random_float($city_bound_lng1, $city_bound_lng2), geodir_random_float($city_bound_lng2, $city_bound_lng1));
		else
			$dummy_post_longitude = geodir_random_float(geodir_random_float($city_bound_lng2, $city_bound_lng1), geodir_random_float($city_bound_lng1, $city_bound_lng2));

		$postal_code = '';
		$address = '';

		$post_address = geodir_get_address_by_lat_lan($dummy_post_latitude, $dummy_post_longitude);


		if (!empty($post_address)) {
			foreach ($post_address as $add_key => $add_value) {
				if ($add_value->types[0] == 'postal_code') {
					$postal_code = $add_value->long_name;
				}

				if ($add_value->types[0] == 'street_number') {
					if ($address != '')
						$address .= ',' . $add_value->long_name;
					else
						$address .= $add_value->long_name;
				}
				if ($add_value->types[0] == 'route') {
					if ($address != '')
						$address .= ',' . $add_value->long_name;
					else
						$address .= $add_value->long_name;
				}
				if ($add_value->types[0] == 'neighborhood') {
					if ($address != '')
						$address .= ',' . $add_value->long_name;
					else
						$address .= $add_value->long_name;
				}
				if ($add_value->types[0] == 'sublocality') {
					if ($address != '')
						$address .= ',' . $add_value->long_name;
					else
						$address .= $add_value->long_name;
				}

			}

			$post_info['post_address'] = $address;
			$post_info['post_city'] = $default_location->city;
			$post_info['post_region'] = $default_location->region;
			$post_info['post_country'] = $default_location->country;
			$post_info['post_zip'] = $postal_code;
			$post_info['post_latitude'] = $dummy_post_latitude;
			$post_info['post_longitude'] = $dummy_post_longitude;

		}
		geodir_save_listing($post_info, true);

	}
}

function dt_geodir_add_dummy_data_tab($arr, $post_type, $name){

	$arr[] = array( 'name' => $name.' Dummy Data', 'type' => 'title', 'desc' => '', 'id' => $post_type.'_dummy_data_settings' );

	$arr[] = array(
			'name' => '',
			'desc' 		=> '',
			'id' 		=> $post_type.'_dummy_data_installer',
			'post_type' => $post_type,
			'type' 		=> 'dummy_installer',
			'css' 		=> 'min-width:300px;',
			'std' 		=> '40'
	);
	$arr[] = array( 'type' => 'sectionend', 'id' => $post_type.'_dummy_data_settings');

	return $arr;
}