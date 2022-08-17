<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <span class="close">&times;</span>
  <label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
  <input type="text" placeholder="What are you looking for?" value="<?php echo get_search_query(); ?>" name="s" id="s" />
  <button type="submit" id="searchsubmit">{!! \App\Controllers\App::svg( 'search_icon' ) !!}<span class="visually-hidden">Search</span></button>
</form>
