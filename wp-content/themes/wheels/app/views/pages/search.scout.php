@include('layouts.header')

<div id="content">
@if(have_posts())
	<header class="page-header">
		<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'theme' ), get_search_query() ); ?></h1>
	</header>
	@include("layouts.loop")
@else
	<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'theme' ); ?></p>
	@include('layouts.searchform')
@endif
</div>

@include('layouts.sidebar')
@include('layouts.footer')
