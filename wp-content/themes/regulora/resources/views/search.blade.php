@extends('layouts.app')
@php
$currentPostType = ( isset( $_GET[ 'post_type' ] ) ) ? $_GET[ 'post_type' ] : 'any';
@endphp
@section('content')
  @include('partials.search.search-header', [ 'currentPostType' => $currentPostType ])
  @include('partials.search.search-content', [ 'currentPostType' => $currentPostType ])
@endsection
