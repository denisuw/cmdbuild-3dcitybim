<?php get_header(); ?>

<div class="container">
	<div class="content-box content-archive">
		<?php if (!have_posts()) : ?>
			<div class="alert-error">
				<p><?php _e('Sorry, no results were found.', 'directory-starter'); ?></p>
			</div>
			<?php get_search_form(); ?>
		<?php endif; ?>
		<?php
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'content' );

			// End the loop.
		endwhile;

		// Previous/next page navigation.
		the_posts_pagination( array(
			'prev_text'          => __( 'Previous', 'directory-starter' ),
			'next_text'          => __( 'Next', 'directory-starter' ),
		) );
		?>
	</div>
</div>

<?php get_footer(); ?>