<?php
/**
 * Template Name: Map
 *
 * @package Directory_Starter
 * @since 1.0.4
 */
get_header('map'); 
//get_header(); 
 ?>
<div>
			<?php
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'content' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				// End the loop.
			endwhile;
			?>





<?php get_footer('map'); ?>

