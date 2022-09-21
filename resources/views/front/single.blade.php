@extends('front.layouts.master')
@section('bg',$contents->image)
@section('content')
@section('title',Str::limit($contents->title,20))
@include('front.widgets.categorywidget')
<article style="min-height: 500px" class="mb-4">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-9 mx-auto">
                {!! $contents->content !!}
            </div>
        </div>
    </div>
</article>
@endsection

