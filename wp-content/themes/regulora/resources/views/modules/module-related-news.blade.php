<div id="news-block-module" class="content-block news-block news-block-with-slider">
  <div class="block-header d-block d-lg-flex align-items-start justify-content-between">
    <h2>{!! $relatedNews[ 'title' ] !!}</h2>
    <div class="go-to-all wp-block-button is-style-link-with-arrow mt-lg-0">
      <a class="block-attorney-link wp-block-button__link" href="/news-insights/">
        All Wins & Insights
      </a>
    </div>
  </div>
  <div class="news-list row slider-news-init">
    @foreach ( $relatedNews[ 'news' ] as $post )
      @include( 'partials.news.news-teaser', $post )
    @endforeach
  </div>
</div>
