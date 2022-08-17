<div class="content-block testimonial-block alignfull fullwidth-104">
  <div class="block-content d-flex position-relative">
    <div class="quote-open">
      {!! \App\Controllers\App::svg( 'quote-open' ) !!}
    </div>
    <div class="h4">Testimonial/Quote</div>
    <h2 class="h1">{!! $testimonial[ 'author' ] !!}</h2>
    <div class="testimonial-description">
      {!! $testimonial[ 'text' ] !!}
    </div>
    <div class="quote-close">
      {!! \App\Controllers\App::svg( 'quote-close' ) !!}
    </div>
  </div>
</div>
