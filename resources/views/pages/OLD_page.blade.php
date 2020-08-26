@extends('layouts.app')

@section('title') {{ $page->title }} @endsection

@section('content')
{!! breadcrumbs([$page->title => $page->url]) !!}


<div class="site-page-content parsed-text">
    {!! $page->parsed_text !!}
</div>
<div class="mb-4">
    <div><strong>Created:</strong> {!! format_date($page->created_at) !!}</div>
    <div><strong>Last updated:</strong> {!! format_date($page->updated_at) !!}</div>
</div>  
@endsection
