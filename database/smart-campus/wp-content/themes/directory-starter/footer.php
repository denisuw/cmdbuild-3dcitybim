<footer id="footer" class="site-footer" role="contentinfo">
	<div class="footer-widgets">
		<div class="container">
			<?php $class = apply_filters('dt_footer_widget_class', 'col-lg-3 col-md-3 col-sm-6 col-xs-12')?>
			<?php if(FOOTER_SIDEBAR_COUNT > 0) { ?>
				<div class="<?php echo $class; ?>">
					<?php dynamic_sidebar('sidebar-footer1');?>
				</div>
			<?php } ?>
			<?php if(FOOTER_SIDEBAR_COUNT > 1) { ?>
				<div class="<?php echo $class; ?>">
					<?php dynamic_sidebar('sidebar-footer2');?>
				</div>
			<?php } ?>
			<?php if(FOOTER_SIDEBAR_COUNT > 2) { ?>
				<div class="<?php echo $class; ?>">
					<?php dynamic_sidebar('sidebar-footer3');?>
				</div>
			<?php } ?>
			<?php if(FOOTER_SIDEBAR_COUNT > 3) { ?>
				<div class="<?php echo $class; ?>">
					<?php dynamic_sidebar('sidebar-footer4');?>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="copyright <?php echo (has_nav_menu( 'footer-links' )) ? 'footer-links-active' : ''; ?>">
		<div class="container">
			<p class="copyright-text">
			<?php do_action('dt_footer_copyright'); ?>
			</p>
			<?php
			if (has_nav_menu( 'footer-links' )) {
				wp_nav_menu( array(
						'theme_location' => 'footer-links',
						'container_class' => 'ds_footer_links'
				) );
			}
			?>
		</div>
	</div>

</footer>
<?php wp_footer(); ?>
</div>
</body>
</html>