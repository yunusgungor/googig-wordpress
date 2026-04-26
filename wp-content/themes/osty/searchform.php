<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="ms-search-widget">
		<input type="search" placeholder="<?php echo esc_attr__( 'Search...', 'osty' ); ?>" value="<?php echo get_search_query(); ?>" name="s" class="search-field" />
        <button aria-label="Search" class="ms-search--btn" type="submit"></button>
	</div>
</form>