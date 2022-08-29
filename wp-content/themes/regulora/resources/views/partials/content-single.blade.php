<article @php post_class('pt-3') @endphp>
  <header>
    <h1 class="entry-title has-primary-color h2 mb-0">{!! get_the_title() !!}</h1>
    @include('partials/entry-meta')
  </header>
  <div class="entry-content">
    @php the_content() @endphp
  </div>
{{--  <footer>--}}
{{--    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}--}}
{{--  </footer>--}}
</article>
