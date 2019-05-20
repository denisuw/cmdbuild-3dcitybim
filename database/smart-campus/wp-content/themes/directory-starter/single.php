<?php get_header(); ?>

<?php do_action('dt_single_before_main_content'); ?>

<?php
$dt_enable_blog_sidebar = esc_attr(get_theme_mod('dt_enable_blog_sidebar', DT_ENABLE_BLOG_SIDEBAR));
$dt_blog_sidebar_position = esc_attr(get_theme_mod('dt_blog_sidebar_position', DT_BLOG_SIDEBAR_POSITION));

if ($dt_enable_blog_sidebar == '1') {
	$content_class = 'col-lg-8 col-md-9';
} else {
	$content_class = 'col-lg-12';
}
?>
<div class="container">
	<div class="row">
	<?php if ($dt_enable_blog_sidebar == '1' && $dt_blog_sidebar_position == 'left') { ?>
		<div class="col-lg-4 col-md-3">
			<div class="sidebar blog-sidebar page-sidebar">
				<?php get_sidebar(); ?>
			</div>
		</div>
	<?php } ?>
	<div class="<?php echo $content_class; ?>">
		<div class="content-box content-single">
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

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				// Previous/next post navigation.
				the_post_navigation( array(
						'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'directory-starter' ) . '</span> ' .
								'<span class="screen-reader-text">' . __( 'Next post:', 'directory-starter' ) . '</span> ' .
								'<span class="post-title">%title</span>',
						'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'directory-starter' ) . '</span> ' .
								'<span class="screen-reader-text">' . __( 'Previous post:', 'directory-starter' ) . '</span> ' .
								'<span class="post-title">%title</span>',
				) );

				// End the loop.
			endwhile;
			?>
		</div>
	</div>
	<?php if ($dt_enable_blog_sidebar == '1' && $dt_blog_sidebar_position == 'right') { ?>
		<div class="col-lg-4 col-md-3">
			<div class="sidebar blog-sidebar page-sidebar">
				<?php get_sidebar(); ?>
			</div>
		</div>
	<?php } ?>
	</div>
</div>


<?php do_action('dt_single_after_main_content'); ?>

<?php get_footer(); ?>