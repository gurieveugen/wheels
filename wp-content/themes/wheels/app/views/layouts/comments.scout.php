@if (!post_password_required() )

<div id="comments" class="comments-area">
	@if(have_comments())
		<h2 class="comments-title">
			<?php
				printf( 
					_nx( 
						'One thought on &ldquo;%2$s&rdquo;', 
						'%1$s thoughts on &ldquo;%2$s&rdquo;', 
						get_comments_number(), 
						'comments title', 
						'theme' 
					),
					number_format_i18n( get_comments_number() ), 
					'<span>' . get_the_title() . '</span>' 
				);
			?>
		</h2>
		<ol class="comment-list">
			<?php
				wp_list_comments( 
					array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 74,
					) 
				);
			?>
		</ol><!-- .comment-list -->
		@if(get_comment_pages_count() > 1 && get_option( 'page_comments' ) )
		<nav class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'theme' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'theme' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'theme' ) ); ?></div>
		</nav><!-- .comment-navigation -->
		@endif

		@if(!comments_open() && get_comments_number())
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'theme' ); ?></p>
		@endif

	@endif

	<?php comment_form(); ?>
</div><!-- #comments -->
@endif