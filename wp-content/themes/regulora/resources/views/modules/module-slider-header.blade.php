@if ( $slider )
  <div id="module-slider-header" class="alignfull">
    <div class="slider-inner">
      <div id="slider-init">
        @foreach ( $slider as $index => $slide )
          <div class="slide sl-{!! $index !!} @if ( $index > 0 ) slide-absolute @endif">
            <div class="slide-inner row p-0 m-0">
              <div class="slide-image col-12 p-0">
                @if ( $slide[ \App\Controllers\App::$acfHSimage ] )
                  {!! \App\Controllers\App::getImageDataByID( $slide[ \App\Controllers\App::$acfHSimage ], 'background-fullwidth' ) !!}
                @endif
              </div>
              <div class="slide-content container text-center">
                <div class="limit-width">
                  @if ( $slide[ \App\Controllers\App::$acfHSsubHeading ] )
                    <div class="slide-subtitle">
                      {{ $slide[ \App\Controllers\App::$acfHSsubHeading ] }}
                    </div>
                  @endif
                  @if ( $slide[ \App\Controllers\App::$acfHSheading ] )
                    <h2 class="slide-title">
                      {{ $slide[ \App\Controllers\App::$acfHSheading ] }}
                    </h2>
                  @endif
                  @if ( $slide[ \App\Controllers\App::$acfHStextContent ] )
                    <div class="slide-description">
                      {!! $slide[ \App\Controllers\App::$acfHStextContent ] !!}
                    </div>
                  @endif
                  @if ( $slide[ \App\Controllers\App::$acfHSbuttons ] )
                    <div class="slide-cta-place">
                      @foreach ( $slide[ \App\Controllers\App::$acfHSbuttons ] as $index => $cta )
                        <a href="{{ $cta[ \App\Controllers\App::$acfHSBlink ] }}" class="link-button {{ $cta[ \App\Controllers\App::$acfHSBtype ] }}">
                          {{ $cta[ \App\Controllers\App::$acfHSBtitle ] }}
                        </a>
                      @endforeach
                    </div>
                  @endif
                </div>
              </div>

            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="slider-controls">
      <div id="prev-slide">{!! \App\Controllers\App::svg( 'chevron-left' ) !!}</div>
      <div id="next-slide">{!! \App\Controllers\App::svg( 'chevron-right' ) !!}</div>
    </div>
    <div id="slide-to-content" class="d-none"><span class="dot"></span></div>
  </div>
@endif
