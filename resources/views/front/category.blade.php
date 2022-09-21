@extends('front.layouts.master')
@section('content')
@section('title',$category->name.' Kategorisi')
<div class="container position-relative px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        @include('front.widgets.categorywidget')
        <div class="col-md-6">
            @include('front.widgets.contentlist')
        </div>
    </div>
</div>
@endsection

