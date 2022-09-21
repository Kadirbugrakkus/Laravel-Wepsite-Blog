@extends('front.layouts.master')
@section('bg',$page->image)
@section('content')
@section('title',Str::limit($page->title,20))
<div class="container px-4 px-lg-5">
    <div class="col-md-9 mx-auto">
        {!! $page->content !!}
    </div>
</div>
@endsection
