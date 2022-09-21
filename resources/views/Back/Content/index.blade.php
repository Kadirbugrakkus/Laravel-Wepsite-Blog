@extends('back.layouts.master')
@section('title','Tüm İçerikler')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4" xmlns="http://www.w3.org/1999/html">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary"><strong>@yield('title')</strong></h6>
            <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{count($content)}} Sonuç Bulundu...</strong>
                <a href="{{route('admin.trashed.content')}}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm btn-warning">
                    <i class="fas fa-trash fa-sm text-white-50"></i> Deleted Content</a></h6>

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
                        <th>Durum</th>
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
                                <input class="switch" contents-id="{{$contents->id}}" type="checkbox" data-toggle="toggle"
                                       data-onstyle="success" data-offstyle="danger"
                                       data-on="Aktif" data-off="Pasif" @if($contents->status==1) checked @endif>
                            </td>
                            <td>
                                <a href="{{route('single',[$contents->getCategory->slug,$contents->slug])}}" target="_blank" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                <a href="{{route('admin.icerikler.edit',$contents->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                                <a href="{{route('admin.delete.content',$contents->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('switch')
    <script>
        $(function () {
            $('.switch').change(function () {
                id = ($(this)[0].getAttribute('contents-id'));
                statu=$(this).prop('checked');
                $.ajax({
                    type: "GET",
                    url: '{{route('admin.switch')}}',
                    data:{
                        id:id,
                        statu:statu
                    },
                    success: function (data) {
                        console.log(data)
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log('xHR: ' + xhr);
                        console.log('ajaxOption: ' + ajaxOptions);
                        console.log('thrownError: ' + thrownError);
                    }
                });
            })
        })
    </script>
@endsection
