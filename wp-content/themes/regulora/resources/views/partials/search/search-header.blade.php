@php
$heroImage = \App\Controllers\App::themeOptions( 'global' );
@endphp
<div class="alignfull top-info mb-120">
  <div class="top-info-overlay d-flex align-items-center header-banner-small page-title-header"  role="region">
    <div class="container-fluid container-xl">
      <div class="row align-items-center">
        @if( $currentPostType != 'any' )
          <h4 class="col-12 back-link mb-4">
            {!! \App\Controllers\App::backLink( "?s=" . urlencode( get_query_var( 's' ) ), 'Back to Results' ) !!}
          </h4>
        @endif
        <div class="name col-12">
          <div class="h4">{!! \App\Controllers\Search::results( 'totalCount' ) !!}
            @if ( $currentPostType != 'any' )
              @switch ($currentPostType)
                @case( \App\Controllers\NewsInsights::$postType )
                News
                @break
                @case( \App\Controllers\Page::$postType )
                Pages
                @break
              @endswitch
            @else
              Results
            @endif
            found for:</div>
          <div class="h1">&#8220;{!! get_query_var( 's' ) !!}&#8221;</div>
        </div>
      </div>
    </div>
  </div>
</div>

@if( ! empty( $heroImage[ 'heroDefaultImage' ][ 'x1' ] ) && ! empty( $heroImageStyles = \App\Controllers\App::setHeroBackgroundImage( 'top-info', $heroImage[ 'heroDefaultImage' ][ 'x1' ], $heroImage[ 'heroDefaultImage' ][ 'x2' ] ) ) )
  {!! $heroImageStyles !!}
@endif
