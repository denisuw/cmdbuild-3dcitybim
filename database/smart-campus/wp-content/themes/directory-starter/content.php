<article <?php post_class(); ?>>
	<header>
		<?php
		if ( is_singular() ) {
			?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php
		} else {
			?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<?php
		}
		?>
	</header>
	<div class="entry-content entry-summary">
		<?php
		global $more;
		$more = 0;
		if (is_singular() || (function_exists('is_bbpress') && is_bbpress())) {
			the_content();
		} else {
			directory_theme_post_thumbnail();
			the_excerpt();
		}
		?>
		<?php
		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'directory-starter' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		) );
		?>
	</div>
	<footer class="entry-footer">
		<?php directory_theme_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'directory-starter' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article>