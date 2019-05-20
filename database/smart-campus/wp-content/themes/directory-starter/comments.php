<?php
/**
 * The template for displaying comments
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area normal-comments">

	<?php
	/**
	 * Called before displaying comments.
	 *
	 * If you would like to wrap comments inside a div this is the place to print your open div. @see dt_before_comment_form to print your closing div.
	 *
	 * @since 1.0.0
	 */
	do_action('dt_before_comment_list'); ?>

	<?php if ( have_comments() ) : ?>
	<div class="commentlist-wrap">
		<h2 class="comments-title">
			<?php
			printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'directory-starter' ),
				number_format_i18n( get_comments_number() ));
			?>
		</h2>

		<?php //directory_theme_comment_nav(); ?>

		<ol class="commentlist">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'callback'    => 'directory_theme_comment'
			) );
			?>
		</ol><!-- .comment-list -->

		<?php directory_theme_comment_nav(); ?>
	</div>
	<?php endif; // have_comments() ?>


	<?php
	/**
	 * Called before displaying "Leave a comment form".
	 *
	 * If you would like to wrap "comment form" inside a div this is the best place to hook your open div. @see dt_after_comment_form to print your closing div.
	 * Also If you would like to wrap "comments" inside a div this is the best place to print your closing div. @see geodir_before_comment_list to print your open div.
	 *
	 * @since 1.0.0
	 */
	do_action('dt_before_comment_form'); ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'directory-starter' ); ?></p>
	<?php endif; ?>

	<?php
	if (function_exists('geodir_login_url')) {
		// geodirectory plugin
		$login_url = geodir_login_url();
	} else {
		$login_url = wp_login_url();
	}
	/**
	 * Filters comment form args
	 *
	 * If you would like to modify your comment form args, use this filter. @see https://codex.wordpress.org/Function_Reference/comment_form for accepted args.
	 *
	 * @since 1.0.0
	 */
	$args = apply_filters('dt_comment_form_args', array(
			'title_reply' => __('Leave a Comment', 'directory-starter'),
			'label_submit' => __('Post Comment', 'directory-starter'),
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . __('Comment text', 'directory-starter') . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
			'must_log_in' => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', 'directory-starter'), $login_url) . '</p>'
	));
	comment_form($args);
	?>

	<?php
	/**
	 * Called after displaying "Leave a comment form".
	 *
	 * If you would like to wrap "comment form" inside a div this is the best place to print your closing div. @see dt_before_comment_form to print your open div.
	 *
	 * @since 1.0.0
	 */
	do_action('dt_after_comment_form'); ?>

</div><!-- .comments-area -->