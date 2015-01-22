@if(have_posts())
<div class="posts-holder">
	@loop
	<article id="post-{{ Loop::id() }}" <?php post_class(); ?>>
		<header class="entry-header">
			@if(has_post_thumbnail() && !post_password_required() )
			<div class="entry-thumbnail">
				{{ Loop::thumbnail() }}
			</div>
			@endif
		
			<h1><a href="{{ Loop::link() }}" rel="bookmark">{{ Loop::title() }}</a></h1>
		
			<div class="entry-meta">
				<?php BaseController::themeEntryMeta(); ?>
				<?php edit_post_link( __( 'Edit', 'theme' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
		</header>

		<div class="entry-content">
			@if(strpos(Loop::content(), '<!--more-->'))
				{{ Loop::content() }}
			@else
				{{ Loop::excerpt() }}
			@endif
			<?php
				wp_link_pages( 
					array( 
						'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'theme' ) . '</span>', 
						'after' => '</div>', 
						'link_before' => '<span>', 
						'link_after' => '</span>' 
					) 
				);
			?>
		</div>

		<footer class="entry-meta">
			@if ( comments_open() && ! is_single() )
			<div class="comments-link">
				<?php 
					comments_popup_link( 
						'<span class="leave-reply">' . __( 'Leave a comment', 'theme' ) . '</span>', 
						__( 'One comment so far', 'theme' ), __( 'View all % comments', 'theme' ) 
					); 	
				?>
			</div>
			@endif
		</footer>
	</article><!-- #post -->
	@endloop
</div><!-- .posts-holder -->
{{ BaseController::themePagingNav() }}
@else
<h1 class="page-title"><?php _e( 'Nothing Found', 'theme' ); ?></h1>
	<div class="page-content">
		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'theme' ); ?></p>
		<?php get_search_form(); ?>
	</div><!-- .page-content -->
@endif