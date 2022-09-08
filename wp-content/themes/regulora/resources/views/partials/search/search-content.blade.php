@if ( \App\Controllers\Search::results( 'totalCount' ) > 0 )
  <div class="search-lists">
    {{--          <pre>@php var_dump(\App\Controllers\Search::results('totalCount')) @endphp</pre>--}}
    @foreach ( \App\Controllers\Search::results() as $post_type => $posts )
      @if ( $posts[ 'total' ] > 0 )
        <div class="post-type-block">
          <div class="row justify-content-between post-type-block-heading
            @if( $currentPostType != 'any' ) d-none @endif
          ">
            <div class="col-auto col-lg-6">
              <h2>
                @switch ($post_type)
                  @case( \App\Controllers\Attorney::$postType )
                  Attorneys
                  @break
                  @case( \App\Controllers\Practices::$postType )
                  Practices
                  @break
                  @case( \App\Controllers\NewsInsights::$postType )
                  Wins & Insights
                  @break
                  @case( \App\Controllers\Page::$postType )
                  Pages
                  @break
                @endswitch
                ({!! $posts[ 'total' ] !!})
              </h2>
            </div>
            @if ( $posts[ 'total' ] > 3 && $currentPostType == 'any' )
              <div class="col-12 col-md-auto align-self-center ml-0">
                <div class="wp-block-button is-style-link-with-arrow">
                  <a class="block-attorney-link wp-block-button__link" href="?s={!! urlencode( get_query_var( 's' ) ) !!}&post_type={!! $post_type !!}">
                    All
                    @switch ($post_type)
                      @case( \App\Controllers\Attorney::$postType )
                      Attorneys
                      @break
                      @case( \App\Controllers\Practices::$postType )
                      Practices
                      @break
                      @case( \App\Controllers\NewsInsights::$postType )
                      Wins & Insights
                      @break
                      @case( \App\Controllers\Page::$postType )
                      Pages
                      @break
                    @endswitch
                    Results
                  </a>
                </div>
              </div>
            @endif
            <hr class="is-style-gray-separator-large">
          </div>
          <div class="row">
            <div class="col-12 items">
              <div class="cols-list row row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-3">
                @foreach ( $posts[ 'posts' ] as $post )
                  @switch ( $post_type )
                    @case( \App\Controllers\Attorney::$postType )
                    @include( 'partials.attorney.attorney-sidebar-teaser', [ 'attorney' => \App\Controllers\Attorney::getFormattedData( $post ) ] )
                    @break
                    @case( \App\Controllers\Page::$postType )
                    @include( 'partials.page.page-teaser', [ 'post' => \App\Controllers\NewsInsights::getFormattedData( $post ) ] )
                    @break
                    @case( \App\Controllers\Practices::$postType )
                    @include( 'partials.news.news-teaser', [ 'post' => \App\Controllers\NewsInsights::getFormattedData( $post ) ] )
                    @break
                    @case( \App\Controllers\NewsInsights::$postType )
                    @include( 'partials.news.news-teaser', [ 'post' => \App\Controllers\NewsInsights::getFormattedData( $post ) ] )
                    @break
                  @endswitch
                @endforeach
              </div>
              @if ($currentPostType != 'any')
                <div class="row justify-content-center">
                  {!! \App\Controllers\App::dc_pagination( \App\Controllers\Search::$queryInstance ) !!}
                </div>
              @endif
            </div>
          </div>
        </div>
      @endif
    @endforeach
  </div>
@else
    @if ( $emptySearchPage = \App\Controllers\App::themeOptions( 'emptySearchPage' ) )
        {!! apply_filters( 'the_content', $emptySearchPage->post_content ) !!}
    @else
        <div class="row">
            <div class="col-12 empty-result">
                {{ __( 'No Results Found', 'sage' ) }}
            </div>
        </div>
    @endif
@endif
