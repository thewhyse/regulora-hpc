@extends('layouts.app')

@section('content')
    @if (!have_posts())
        <div class="alert alert-warning">
            {{ __('Sorry, no results were found.', 'sage') }}
        </div>
        {!! get_search_form(false) !!}
    @endif

    <div class="pt-5"></div>
    <h3 class="text-black">Search results for query "{!! get_query_var( 's' ) !!}":</h3>
    <div class="pt-3"></div>
    @while(have_posts()) @php the_post() @endphp
    @include('partials.content-search')
    @endwhile
    <div class="pt-5"></div>
    {!! get_the_posts_navigation() !!}
@endsection