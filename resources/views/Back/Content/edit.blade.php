@extends('back.layouts.master')
@section('title',$icerik->title.' makalesini güncelle')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4" xmlns="http://www.w3.org/1999/html">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary"><strong>@yield('title')</strong></h6>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </div>
            @endif
            <form method="post" action="{{route('admin.icerikler.update',$icerik->id)}}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label>İçerik Başlığı</label>
                    <input type="text" name="title" class="form-control" value="{{$icerik->title}}" required>
                </div>
                <div class="form-group">
                    <label>İçerik Kategorisi</label>
                    <select class="form-control" name="category" required>
                        <option value="">Seçim Yapınız</option>
                        @foreach($categories as $category)
                            <option @if($icerik->category_id==$category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>İçerik Fotoğrafı</label><br>
                    <img src="{{asset($icerik->image)}}" class="img-thumbnail rounded" width="300">
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label>İçerik Detayı</label>
                    <textarea name="icerikContent" id="editor" class="form-control" rows="4">{!! $icerik->content !!}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">İçeriği Güncelle</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('js')
    <!-- include summernote js -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editor').summernote(
                {
                    'height':250
                }
            );
        });
    </script>
@endsection
