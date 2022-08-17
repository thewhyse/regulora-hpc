@extends('layouts.app-fullwidth')

@section('content')

    <h2 class="has-primary-color">
        {!! get_queried_object()->name !!}
    </h2>

    @if ( $news = \App\Controllers\NewsInsights::posts( 3, get_query_var('cat') ) )
        @php $viewType = get_field( 'category_view_type', 'term_' . get_query_var('cat') ); @endphp
        <div class="list view-type-{!! $viewType !!}">
            @foreach( $news as $post )
            <div class="post-item">
                @if ( $viewType == 'grid' )
                <div class="featured-image">
                    <a href="{!! $post[ 'url' ] !!}">
                        {!! App::getFeaturedImage( $post[ 'id' ], $post[ 'title' ] )  !!}
                    </a>
                </div>
                @endif
                @if ( $viewType == 'grid' )
{{--                <div class="post-title">--}}
{{--                    <a href="{!! $post[ 'url' ] !!}">--}}
{{--                        {!! $post[ 'title' ] !!}--}}
{{--                    </a>--}}
{{--                </div>--}}
                @endif
                <div class="post-date">
                    {!! $post[ 'date' ] !!}
                </div>
                <div class="post-desc">
                    {!! $post[ 'excerpt' ] !!}
                </div>
            </div>
            @endforeach
        </div>
        {!! \App\Controllers\App::dc_pagination( \App\Controllers\NewsInsights::$instance, ( get_query_var('cat') ? get_query_var('cat') : 0 ) ) !!}
        <div class="mb-5"></div>
    @else
        <div class="alert alert-warning py-125">
            {{ __('Sorry, no results were found.', 'sage') }}
        </div>
    @endif
@endsection
