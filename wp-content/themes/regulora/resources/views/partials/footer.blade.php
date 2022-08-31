<footer class="page-footer content-info">
  <div class="container">
    <div class="alignwide">
      <div class="row mx-0 align-items-center">
        <div class="col-12 col-lg-1 p-0 text-center">
          <a class="footer-logo" href="{{ home_url('/') }}" aria-label="Footer Logo">
            {!! \App\Controllers\App::siteLogo( 'footer' ) !!}
          </a>
        </div>
        <div class="col-12 col-lg-11 p-0">
          <div class="row mx-0 h-100">
            <div class="col-12 mb-lg-2 align-self-start">
              @if (has_nav_menu('footer_navigation'))
                {!! wp_nav_menu( [ 'theme_location' => 'footer_navigation', 'menu_class' => 'nav-footer' ] ) !!}
              @endif
            </div>
            <div class="col-12 align-self-end under-menu">
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
        <div class="row align-items-end gap-3 gap-lg-0">
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
  <div id="back-to-top">
    <span>Back to top</span><div class="icon"><?=\App\Controllers\App::svg( 'back-to-top' )?></div>
  </div>
</footer>
<?php if ( ! isset( $_COOKIE[ 'usertype' ] ) || $_COOKIE[ 'usertype' ] != 'professional' ) : ?>
<div id="choice-popup" class="show">
  <div class="inner">
    <h2>ARE YOU A US HEALTHCARE PROFESSIONAL?</h2>
    <p>The information provided in this website is<br/>intended for US healthcare professionals only</p>
    <div class="buttons">
      <a id="prof" class="make-choice">
        I am a US<br/>healthcare professional
      </a>
      <a href="https://regulora.com" id="patient" class="make-choice">
        Go to the<br/>patient website
      </a>
    </div>
  </div>
</div>
<?php endif; ?>
