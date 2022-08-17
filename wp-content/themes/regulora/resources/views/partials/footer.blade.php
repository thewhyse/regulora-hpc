<footer class="page-footer content-info">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <a class="footer-logo" href="{{ home_url('/') }}" aria-label="Footer Logo">
          {!! \App\Controllers\App::siteLogo( 'footer' ) !!}
        </a>
      </div>
      <div class="col-12">
        @if (has_nav_menu('footer_navigation'))
          {!! wp_nav_menu( [ 'theme_location' => 'footer_navigation', 'menu_class' => 'nav-footer' ] ) !!}
        @endif
      </div>
    </div>
  </div>
  <div class="bg-primary footer-widets">
    <div class="container">
      <div class="alignwide">
        <div class="row align-items-end">
          <div class="col-12 col-lg-4">
            @php dynamic_sidebar('sidebar-footer-left') @endphp
          </div>
          <div class="col-12 col-lg-4">
            @php dynamic_sidebar('sidebar-footer-center') @endphp
          </div>
          <div class="col-12 col-lg-4">
            @php dynamic_sidebar('sidebar-footer-right') @endphp
            <div class="copyright">
              {!! App::siteFooterCopyright() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
