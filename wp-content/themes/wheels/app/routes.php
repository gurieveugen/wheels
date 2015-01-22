<?php

/*
 * Define your routes and which views to display
 * depending of the query.
 *
 * Based on WordPress conditional tags from the WordPress Codex
 * http://codex.wordpress.org/Conditional_Tags
 *
 */

Route::get('home', array(array('front'), 'uses' => 'HomeController@index'));
Route::get('page', 'PageController@index');
Route::get('404', 'NotFoundController@index');
Route::get('archive', 'ArchiveController@index');
Route::get('single', 'SingleController@index');
Route::get('search', function(){
	return View::make('pages.search', array('search' => $_GET['s']));
});
