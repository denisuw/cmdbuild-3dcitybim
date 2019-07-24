<?php header("Access-Control-Allow-Origin: *");  ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
<!-- Additional -->

    <link rel="stylesheet" href="/petakampus/pk-assets/css/bootstrap-switch.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- 
    <link rel="stylesheet" href="/petakampus/pk-assets/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/petakampus/pk-assets/font-awesome/4.7.0/css/font-awesome.min.css" />  -->
    <link rel="stylesheet" href="/petakampus/pk-assets/ol3-cesium/ol.css">
    <link rel="stylesheet" href="/petakampus/pk-assets/css/inovamap.css" />
	
	<link href="/petakampus/pk-assets/css/ol-contextmenu.css" rel="stylesheet">

	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
	
	<script src="/petakampus/pk-assets/js/proj4.js"></script>
	<script src="/petakampus/pk-assets/ol3-cesium/inject_ol_cesium.js"></script>
	<!--<script src="/petakampus/pk-assets/ol3-cesium/Cesium/Cesium.js"></script>-->
	<script src="/petakampus/pk-assets/ol3-cesium/olcesium.js"></script>
	<script type="text/javascript" src="//code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="/petakampus/pk-assets/js/bootstrap-switch.min.js"></script>
	<script src="/petakampus/pk-assets/js/jssor.slider.min.js"></script>
	<!-- script type="text/javascript" src="/petakampus/pk-assets/bootstrap/3.3.7/js/bootstrap.min.js"></script-->
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<script src="/petakampus/pk-assets/inovamap/0.0.1/js/inovamap-ui.js"></script>
	<script src="/petakampus/pk-assets/js/ol-contextmenu.js"></script>
	<!--panellum-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.2/build/pannellum.css"/>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/pannellum@2.5.2/build/pannellum.js"></script>
	
    <title>Peta 3D</title>
	
<!-- Additional End -->
	
</head>

<body <?php body_class(); ?>>
<div id="ds-container" >
<?php do_action('dt_before_header'); ?>
<?php
$enable_header_top = esc_attr(get_theme_mod('dt_enable_header_top', DT_ENABLE_HEADER_TOP));
if ($enable_header_top == '1') {
	$extra_class = 'dt-header-top-enabled';
} else {
	$extra_class = '';
}
?>
<header id="site-header" class="site-header <?php echo $extra_class; ?>" role="banner" style="<?php echo dt_header_image(); ?>">

	<div class="container">

        <?php
        /**
         * This action is called before the site logo wrapper.
         *
         * @since 1.0.2
         */
        do_action('dt_before_site_logo');?>

		<div class="site-logo-wrap">
			<?php if ( get_theme_mod( 'logo', false ) ) : ?>
				<div class='site-logo'>
					<a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo esc_url( get_theme_mod( 'logo', false ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
</a>

				</div>
			<?php else : ?>
				<?php
				if ( display_header_text() )
					$style = ' style="color:#' . get_header_textcolor() . ';"';
				else
					$style = ' style="display:none;"';

				if ( display_header_text() ) : ?>
				<?php
				$desc = get_bloginfo( 'description', 'display' );
				$class = '';
				if (!$desc) {
					$class = 'site-title-no-desc';
				}
				?>
				<hgroup>
					
					<h1 class='site-title <?php echo $class; ?>'>
						<a <?php echo $style; ?> href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php bloginfo( 'name' ); ?></a>
					</h1>
					<?php
					if ($enable_header_top != '1') { ?>
						<h2 class="site-description">
							<a <?php echo $style; ?> href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( $desc ); ?>' rel='home'><?php echo $desc; ?></a>
						</h2>
					<?php } ?>
				</hgroup>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
		<nav id="primary-nav" class="primary-nav" role="navigation">
			<?php
				wp_nav_menu( array(
					'container'      => false,
					'theme_location' => 'primary-menu',
				) );
			?>
		</nav>

		<?php
            /**
             * Filter the mobile navigation button html.
             *
             * @since 1.0.2
             */
            echo apply_filters('dt_mobile_menu_button','<div class="dt-nav-toggle  dt-mobile-nav-button-wrap"><a href="#primary-nav"><i class="fa fa-bars"></i></a></div>');
        } ?>




	</div>
</header>
<?php do_action('dt_after_header'); ?>