@php
  $heroImage = \App\Controllers\App::themeOptions( 'global' );
@endphp
<div class="alignfull top-info">
  <div class="top-info-overlay d-flex align-items-center header-banner-small page-title-header"  role="region">
    <div class="container-fluid container-xl">
      <div class="row align-items-center">
        <div class="name col-12">
          <div class="h1">{!! \App\Controllers\App::title() !!}</div>
        </div>
      </div>
    </div>
  </div>
</div>

@if( ! empty( $heroImage[ 'heroDefaultImage' ][ 'x1' ] ) && ! empty( $heroImageStyles = \App\Controllers\App::setHeroBackgroundImage( 'top-info', $heroImage[ 'heroDefaultImage' ][ 'x1' ], $heroImage[ 'heroDefaultImage' ][ 'x2' ] ) ) )
  {!! $heroImageStyles !!}
@endif
