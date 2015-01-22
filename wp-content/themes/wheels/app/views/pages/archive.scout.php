@include('layouts.header')
<div id="content" role="main">
	<h1 class="archive-title">
		@if (is_category()) 
		<?php 
		printf( 
			__( 'Category Archives: %s', 'theme' ), 
			single_cat_title( '', false ) 
		); ?>
		@elseif(is_tag()) 
		<?php 
		printf( 
			__( 'Tag Archives: %s', 'theme' ), 
			single_tag_title( '', false ) 
		); ?>
		@elseif(is_day()) 
		<?php 
		printf( 
			__( 'Daily Archives: %s', 'theme' ), 
			get_the_date() 
		); ?>
		@elseif(is_month()) 
		<?php 
		printf( 
			__( 'Monthly Archives: %s', 'theme' ), 
			get_the_date( _x( 'F Y', 'monthly archives date format', 'theme' ) ) 
		); ?>
		@elseif ( is_year() )
		<?php 
		printf( 
			__( 'Yearly Archives: %s', 'theme' ), 
			get_the_date( _x( 'Y', 'yearly archives date format', 'theme' ) ) 
		); ?>
		@elseif (is_author())
		<?php
		printf( 
			__( 'All posts by %s', 'theme' ), 
			'<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' 
		); ?>
		@else
			_e( 'Archives', 'theme' );
		@endif
		
	</h1>
	@include('layouts.loop')
</div>

@include('layouts.sidebar')
@include('layouts.footer')
