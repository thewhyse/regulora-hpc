{{--
  Template Name: Fullwidth Page
--}}

@extends( 'layouts.app-fullwidth' )

@section('content')
  @while(have_posts()) @php the_post() @endphp
  @include('partials.content-page')
  @endwhile
@endsection
