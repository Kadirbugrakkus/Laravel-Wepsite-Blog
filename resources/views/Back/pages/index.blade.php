@extends('back.layouts.master')
@section('title','Tüm Sayfalar')
@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4" xmlns="http://www.w3.org/1999/html">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold float-left text-primary"><strong>@yield('title')</strong></h6>
            <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{count($pages)}} Sonuç Bulundu...</strong></h6>
        </div>
        <div class="card-body">
            <div class="alert alert-success" id="orderSuccess">Sıralama Başarıyla Güncellendi...</div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Fotoğraf</th>
                        <th>İçerik Başlığı</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody id="orders">
                    @foreach($pages as $page)
                        <tr id="page_{{$page->id}}">
                            <td>
                                <img src="{{asset($page->image)}}" width="150" style="border-radius: 5px">
                            </td>
                            <td>{{Str::limit($page->title,20)}}</td>
                            <td>
                                <input class="switch" contents-id="{{$page->id}}" type="checkbox" data-toggle="toggle"
                                       data-onstyle="success" data-offstyle="danger"
                                       data-on="Aktif" data-off="Pasif" @if($page->status==1) checked @endif>
                            </td>
                            <td>
                                <a href="{{route('page',$page->slug)}}" target="_blank" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                <a href="{{route('admin.page.edit',$page->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i></a>
                                <a category-id="{{$page->id}}"  page-name="{{$page->name}}" title="Sayfayı Sil"
                                   class="btn btn-sm btn-danger remove-click"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sayfayı Sil</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="body">
                    <div class="alert alert-danger" id="contentAlert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <form action="{{route('admin.page.delete')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="deleteId"/>
                        <button id="deleteButton" type="submit" class="btn btn-success">Sil</button>
                    </form>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('switch')
    <script>
        $(function () {
            $('.remove-click').click(function () {
                id = ($(this)[0].getAttribute('category-id'));
                name = ($(this)[0].getAttribute('page-name'));

                $('#deleteButton').show();
                $('#deleteId').val(id);

                $('#contentAlert').html('Bu Sayfayı silmek istediğinize emin misiniz ?')
                $('#deleteModal').modal();
            });
            //
            $('.switch').change(function () {
                id = ($(this)[0].getAttribute('contents-id'));
                statu=$(this).prop('checked');
                $.ajax({
                    type: "GET",
                    url: '{{route('admin.page.switch')}}',
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
@section('js')
    <!-- Sortablejs -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script>
        $('#orders').sortable({
            update:function ()
            {
                var siralama = $('#orders').sortable('serialize');
                $.get('{{route('admin.page.orders')}}?'+siralama,function (data,status)
                {
                    $('#orderSuccess').show().delay(1000).fadeOut();
                });
            }
        })
    </script>
@endsection

@endsection

