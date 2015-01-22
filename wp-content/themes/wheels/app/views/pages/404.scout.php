@include('layouts.header')
<div id="content">
	<h1 class="page-title"><?php _e( 'Not found', 'theme' ); ?></h1>
	<div class="page-content">
		<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'theme' ); ?></h2>
		<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'theme' ); ?></p>
		@include('searchform')
	</div>
</div>
@include('layouts.footer')