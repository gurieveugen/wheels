<nav class="navigation paging-navigation" role="navigation">
    <div class="nav-links cf">
        @if ( get_next_posts_link() )
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'theme' ) ); ?></div>
        @endif
        @if ( get_previous_posts_link() )
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'theme' ) ); ?></div>
        @endif
    </div><!-- .nav-links -->
</nav><!-- .navigation -->