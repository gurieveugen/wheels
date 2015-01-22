@include('layouts.header')
<article id="content">
@loop
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="page-header">
			@if(has_post_thumbnail() && ! post_password_required())
			<div class="page-thumbnail">
				{{ Loop::thumbnail() }}
			</div>
			@endif

			<h1 class="entry-title">{{ Loop::title() }}</h1>
		</header><!-- .entry-header -->

		<div class="page-content">
			{{ Loop::content() }}
			<?php 
			wp_link_pages( 
				array( 
					'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'theme' ) . '</span>', 
					'after' => '</div>', 
					'link_before' => '<span>', 
					'link_after' => '</span>' 
				) 
			); ?>
		</div><!-- .entry-content -->

		<footer class="entry-meta">
			<?php 
			edit_post_link( 
				__( 'Edit', 'theme' ), 
				'<span class="edit-link">', 
				'</span>' 
			); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
	@include('layouts.comments')
@endloop
</article>
@include('layouts.sidebar')
@include('layouts.footer')