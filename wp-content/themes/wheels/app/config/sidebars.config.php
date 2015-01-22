<?php

return array(

	/*
	* Edit this file to add widget sidebars to your theme. 
	* Place WordPress default settings for sidebars.
	* Add as many as you want, watch-out your commas!
	*/
	array(
		'id'            => 'home-sidebar',
		'name'          => __('Home Sidebar', THEMOSIS_THEME_TEXTDOMAIN),
		'description'	=> __('Area of home sidebar', THEMOSIS_THEME_TEXTDOMAIN),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	)
);