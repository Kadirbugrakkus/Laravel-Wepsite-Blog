@extends('back.layouts.master')
@section('title','Tüm Kategoriler')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Yeni Kategori Oluştur</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.category.create')}}">
                        @csrf
                        <div class="form-group">
                            <label>Kategor Adı</label>
                            <input type="text" class="form-control" name="category" required/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Ekle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold float-left text-primary">@yield('title')</h6>
                    <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{count($categories)}} Sonuç Bulundu...</strong></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Kategori Adı</th>
                                <th>İçerik Sayısı</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->name}}</td>
                                    <td>{{count($category->categoryCount)}}</td>
                                    <td>
                                        <input class="switch" category-id="{{$category->id}}" type="checkbox"
                                               data-toggle="toggle"
                                               data-onstyle="success" data-offstyle="danger"
                                               data-on="Aktif" data-off="Pasif"
                                               @if($category->status==1) checked @endif>
                                    </td>
                                    <td>
                                        <a category-id="{{$category->id}}" title="Kategoriyi Düzenle"
                                           class="btn btn-sm btn-primary edit-click"><i class="fa fa-pen"></i></a>
                                        <a category-id="{{$category->id}}"
                                           category-count="{{count($category->categoryCount)}}" category-name="{{$category->name}}" title="Kategoriyi Sil"
                                           class="btn btn-sm btn-danger remove-click"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kategoriyi Düzenle</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.category.update')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Kategori Adı</label>
                            <input type="text" id="category" class="form-control" name="category"/>
                            <input type="hidden" name="id" id="category_id"/>
                        </div>
                        <div class="form-group">
                            <label>Kategori Slug</label>
                            <input type="text" id="slug" class="form-control" name="slug"/>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-success">Kaydet</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kategoriyi Sil</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="body">
                    <div class="alert alert-danger" id="contentAlert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <form action="{{route('admin.category.delete')}}" method="post">
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
            //
            $('.remove-click').click(function () {
                id = ($(this)[0].getAttribute('category-id'));
                count = ($(this)[0].getAttribute('category-count'));
                name = ($(this)[0].getAttribute('category-name'));

                if (id == 1) {
                    $('#contentAlert').html(name + ' kategorisi sabittir. Silinen kategorilerin içerikleri buraya taşınacaktır...')
                    $('#body').show();
                    $('#deleteButton').hide();
                    $('#deleteModal').modal();
                    return;
                }

                $('#deleteButton').show();
                $('#deleteId').val(id);
                if (count > 0) {
                    $('#contentAlert').html('Bu kategoriye ait ' + count + ' içerik bulunmaktadır. Silmek istediğinize emin misiniz ?')
                } else {
                    $('#contentAlert').html('Bu kategoriye ait içerik bulunmamaktadır. Silmek istediğinize emin misiniz ?');
                }
                $('#deleteModal').modal();
            })
            //
            $('.edit-click').click(function () {
                id = ($(this)[0].getAttribute('category-id'));
                $.ajax({
                    type: 'GET',
                    url: '{{route('admin.kategoriler.getdata')}}',
                    data: {id: id},
                    success: function (data) {
                        console.log(data);
                        $('#category').val(data.name);
                        $('#slug').val(data.slug);
                        $('#category_id').val(data.id);
                        $('#editModal').modal();
                    }
                })
            })
            //
            $('.switch').change(function () {
                id = ($(this)[0].getAttribute('category-id'));
                statu = $(this).prop('checked');
                $.ajax({
                    type: "GET",
                    url: '{{route('admin.kategoriler.switch')}}',
                    data: {
                        id: id,
                        statu: statu
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
