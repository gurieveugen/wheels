<?php

// ==============================================================
// Assets
// ==============================================================
Asset::add('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js');
Asset::add('theme-style', TDU.'/css/style.css');

// ==============================================================
// Theme support
// ==============================================================
add_theme_support('automatic-feed-links');
add_theme_support(
	'html5', 
	array(
		'search-form', 
		'comment-form', 
		'comment-list'
	) 
);

// ==============================================================
// Sidebars
// ==============================================================
register_sidebar(
	array(
		'id'            => 'right-sidebar',
		'name'          => 'Right Sidebar',
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	)
);