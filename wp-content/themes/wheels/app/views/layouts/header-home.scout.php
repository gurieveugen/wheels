<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title>{{ BaseController::getPageTitle() }}</title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="wrapper">
		<header id="header">
			<h1 class="logo">
				<a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
					<?php bloginfo('name'); ?>
				</a>
			</h1>
			<?php 
			wp_nav_menu( 
				array(
					'container' => false,
					'theme_location' => 'primary_nav',
					'menu_id' => 'nav',
					'menu_class' => 'navigation'
					/*'walker' => new Custom_Walker_Nav_Menu*/
				)
			); 
			?>
		</header>
		<div id="main">