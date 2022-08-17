<div class="news-item col-12
  @unless( isset( $post[ 'useFullWidth' ] ) && $post[ 'useFullWidth' ] == true ) col-lg-4 @endunless
  ">
  <div class="inner position-relative">
    <a href="{!! $post[ 'url' ] !!}" class="stretched-link"></a>
    <div class="news-thumb">
      {!! \App\Controllers\App::getFeaturedImage( $post[ 'id' ], $post[ 'title' ] ) !!}
    </div>
    <h3>
      {!! $post[ 'title' ] !!}
    </h3>
    <div class="wp-block-button is-style-link-with-arrow">
      <a class="block-attorney-link wp-block-button__link" href="{!! $post[ 'url' ] !!}">
        View Page
      </a>
    </div>
  </div>
</div>
