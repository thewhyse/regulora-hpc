@php
$heroImage = \App\Controllers\Page::getHeroImage();
@endphp
<div class="alignfull top-info">
  <div class="top-info-overlay d-flex align-items-center header-banner-tall header-banner-big"  role="region">
    <div class="container-fluid container-xl">
      <div class="row align-items-center">
        <div class="name col-12">
          <div class="h1 @if( !empty( $color = \App\Controllers\Page::getPageTitleColor() ) ) text-{{ $color }} @endif">{!! get_the_title() !!}</div>
        </div>
      </div>
    </div>
  </div>
</div>

@if( ! empty( $heroImage[ 'heroDefaultImage' ][ 'x1' ] ) && ! empty( $heroImageStyles = \App\Controllers\App::setHeroBackgroundImage( 'top-info', $heroImage[ 'heroDefaultImage' ][ 'x1' ], $heroImage[ 'heroDefaultImage' ][ 'x2' ] ) ) )
  {!! $heroImageStyles !!}
@endif
