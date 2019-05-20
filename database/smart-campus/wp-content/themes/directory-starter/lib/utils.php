<?php
function directory_theme_paginate() {
	global $wp_query;
	$big_num = 999999999;
	if ( $wp_query->max_num_pages <= 1 )
		return;
	echo '<nav class="pagination">';
	echo paginate_links( array(
		'base'         => str_replace( $big_num, '%#%', esc_url( get_pagenum_link($big_num) ) ),
		'format'       => '',
		'current'      => max( 1, get_query_var('paged') ),
		'total'        => $wp_query->max_num_pages,
		'prev_text'    => '&larr;',
		'next_text'    => '&rarr;',
		'type'         => 'list',
		'end_size'     => 3,
		'mid_size'     => 3
	) );
	echo '</nav>';
}

function dt_header_image() {
	$style = '';
	if ($url = esc_url( get_header_image() )) {
		$style = 'background: url('.$url.') no-repeat scroll top;';
	}
	return $style;
}

// Replaces the excerpt "more" text by a link
function dt_excerpt_more() {
	global $post;
	return '<a class="moretag" href="'. get_permalink($post->ID) . '"> Read more...</a>';
}
add_filter('excerpt_more', 'dt_excerpt_more');