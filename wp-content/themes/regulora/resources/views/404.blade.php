@extends('layouts.app')

@section('content')

  @if ( ! have_posts() )
    @if ( $notFoundPage = \App\Controllers\App::themeOptions( '404page' ) )
      {!! apply_filters( 'the_content', $notFoundPage->post_content ) !!}
    @else
      <h2 class="alert alert-warning mb-5">
          NO RESULTS FOUND
      </h2>
      <div>The page you requested could not be found. <br />Try refining your search, or use the navigation above to locate content.</div>
      <div>&nbsp;</div>
      
      @endif
  @endif
@endsection
