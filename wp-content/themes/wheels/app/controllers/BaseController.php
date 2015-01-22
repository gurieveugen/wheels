<?php

class BaseController extends Controller
{
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * Theme enty meta
     */
    public static function themeEntryMeta() 
    {
        if ( is_sticky() && is_home() && ! is_paged() )
            printf('<span class="featured-post">%s</span>', __( 'Sticky', 'theme' ));

        if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
            self::themeEntryDate();

        // Translators: used between list items, there is a space after the comma.
        $categories_list = get_the_category_list( __( ', ', 'theme' ) );
        if ( $categories_list ) 
        {
            echo '<span class="categories-links">' . $categories_list . '</span>';
        }

        // Translators: used between list items, there is a space after the comma.
        $tag_list = get_the_tag_list( '', __( ', ', 'theme' ) );
        if ( $tag_list ) 
        {
            echo '<span class="tags-links">' . $tag_list . '</span>';
        }

        // Post author
        if ( 'post' == get_post_type() ) 
        {
            printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                esc_attr( sprintf( __( 'View all posts by %s', 'theme' ), get_the_author() ) ),
                get_the_author()
            );
        }
    }

    /**
     * Theme entry date
     * @param  boolean $echo --- print or no
     * @return string --- html code
     */
    public static function themeEntryDate( $echo = true ) 
    {
        if ( has_post_format( array( 'chat', 'status' ) ) ) $format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'theme' );
        else $format_prefix = '%2$s';

        $date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
            esc_url( get_permalink() ),
            esc_attr( sprintf( __( 'Permalink to %s', 'theme' ), the_title_attribute( 'echo=0' ) ) ),
            esc_attr( get_the_date( 'c' ) ),
            esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
        );

        if ( $echo ) echo $date;

        return $date;
    }

    /**
     * Theme two links: next and prev posts
     * @return string --- html paging
     */
    public static function themePagingNav() 
    {
        global $wp_query;

        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) return;
        return View::make('layouts.navigation');
    }

    /**
     * Get page title
     * @return string --- page title
     */
    public static function getPageTitle()
    {
        $title = wp_title( ' ', false, 'right' );
        return $title == '' ? get_bloginfo('name') : $title;
    }
} 