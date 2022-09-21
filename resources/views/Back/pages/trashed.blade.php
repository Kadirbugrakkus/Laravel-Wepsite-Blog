@extends('back.layouts.master')
@section('title','Silinen İçerikler')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4" xmlns="http://www.w3.org/1999/html">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary"><strong>@yield('title')</strong></h6>
            <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{count($content)}} Sonuç Bulundu...</strong></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Fotoğraf</th>
                        <th>İçerik Başlığı</th>
                        <th>Kategori</th>
                        <th>Hit</th>
                        <th>Oluşturma Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($content as $contents)
                        <tr>
                            <td>
                                <img src="{{asset($contents->image)}}" width="150" style="border-radius: 5px">
                            </td>
                            <td>{{Str::limit($contents->title,20)}}</td>
                            <td>{{$contents->getCategory->name}}</td>
                            <td>{{$contents->hit}}</td>
                            <td>{{$contents->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{route('admin.recover.content',$contents->id)}}" title="Kurtar" class="btn btn-sm btn-success"><i class="fa fa-recycle"></i></a>
                                <a href="{{route('admin.hard.delete.content',$contents->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
