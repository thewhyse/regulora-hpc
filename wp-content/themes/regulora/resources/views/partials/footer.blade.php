<footer class="page-footer content-info">
  <div class="container">
    <div class="alignwide">
      <div class="row mx-0 align-items-end">
        <div class="col-1 p-0 text-center">
          <a class="footer-logo" href="{{ home_url('/') }}" aria-label="Footer Logo">
            {!! \App\Controllers\App::siteLogo( 'footer' ) !!}
          </a>
        </div>
        <div class="col-11 p-0">
          <div class="row mx-0 h-100">
            <div class="col-12 align-self-start">
              @if (has_nav_menu('footer_navigation'))
                {!! wp_nav_menu( [ 'theme_location' => 'footer_navigation', 'menu_class' => 'nav-footer' ] ) !!}
              @endif
            </div>
            <div class="col-12 align-self-end">
              @php dynamic_sidebar('sidebar-footer-under-menu') @endphp
            </div>
          </div>
        </div>
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
