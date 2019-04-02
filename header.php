</header><!-- #masthead -->

<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Fundify
 * @since Fundify 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]> <html class="ie7 oldie" lang="en" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]> <html class="ie8 oldie" lang="en" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]> <html class="ie9" lang="en" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<!-- <link rel="profile" href="http://gmpg.org/xfn/11" /> -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:700' rel='stylesheet' type='text/css'>
	
	<?php wp_head(); ?>
</head>

<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>

	
<body <?php body_class(); ?>>
	<header id="header" class="site-header" role="banner">
		<?php do_action('icl_language_selector'); ?>

		<!-- / pastilla torta 
                <div class="pastilla"><h2><?php echo __('<a href="/en/coopfunding-v1-0-with-fairbill">New v1.0</a>','fundify-child'); ?></h2></div>
		-->
		<div class="container">
			
			<hgroup>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php $header_image = get_header_image();
						if ( ! empty( $header_image ) ) : ?>
							<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
					<?php endif; ?>
					
					<!-- /bumbum: aqui poso el titol COOPFUNDING amb spans per l'efecte OOs juntes -->
					<h1 class="site-title"><span class="fosc">COOP</span>FUNDING <span class="eslogan"><?php echo __('free and cooperative cofinancing','fundify-child').'</span>'; //bloginfo( 'name' ); ?>
						
					</h1>
				</a>
			</hgroup>
			
			<!-- / navigation -->
			<a href="#" class="menu-toggle" style="/*margin-top: 120px;*/"><i class="icon-menu"></i></a>
			<nav id="menu">
				<?php wp_nav_menu( array( 'theme_location' => 'primary-left', 'container' => false ) ); ?>
				<?php wp_nav_menu( array( 'theme_location' => 'primary-right', 'container' => false, 'menu_class' => 'right' ) ); ?>
			</nav>
		
		</div>
		<!-- / container -->
	</header>
	<!-- / header -->
