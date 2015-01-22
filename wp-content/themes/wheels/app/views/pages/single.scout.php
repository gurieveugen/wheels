@include('layouts.header')

<article id="content">
@loop
	<div id="post-{{ Loop::id() }}" <?php post_class(); ?>>
		<h1 class="entry-title">{{ Loop::title() }}</h1>
		<div class="entry-meta">
			Posted on 
			<a href="<?php the_permalink() ?>" rel="bookmark">
				<span class="entry-date"><?php the_date() ?></span>
			</a> 
			by 
			<span class="author vcard">
				<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>"><?php the_author() ?></a>
			</span>
		</div>

		<div class="entry-content">
			{{ Loop::content() }}
			<?php 
			wp_link_pages( 
				array( 
					'before' => '<div class="page-link"><span>' . __( 'Pages:', 'theme' ) . '</span>', 
					'after' => '</div>' ) 
				); ?>
		</div>

		<div class="entry-meta">
			{{ BaseController::themeEntryMeta() }}
			<?php edit_post_link( 'Edit' , '<span class="edit-link">', '</span>' ); ?>
		</div>
	</div>

	<div id="nav-below" class="navigation nav-single">
		<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous Entry: %title', 'theme' ) ); ?></span>
		<span class="nav-next"><?php next_post_link( '%link', __( 'Next Entry: %title <span class="meta-nav">&rarr;</span>', 'theme' ) ); ?></span>
	</div>
	@include('layouts.comments')
@endloop

</article>

@include('layouts.sidebar')
@include('layouts.footer')
