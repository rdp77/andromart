@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Master Role'))
@section('titleContent', __('Master Role'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Master Role') }}</div>
@endsection

@section('content')
{{-- @include('pages.backend.components.filterSearch') --}}
@include('layouts.backend.components.notification')
<form action="" method="POST" class="form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('role.create') }}" class="btn btn-icon icon-left btn-primary">
                        <i class="far fa-edit"></i>{{ __(' Tambah Role') }}</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" width="50%">
                        <tr>
                            <td width="5%">Level</td>
                            <td width="30%">
                                <select class="select2 level" name="roles">
                                    <option value="">{{ __('- Select -') }}</option>
                                    @foreach ($role as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                {{-- <button class="btn btn-primary mr-1" type="button">Tambah Role</button> --}}
                                {{-- <a href="{{ route('role.create') }}" --}} {{-- class="btn btn-primary mr-1">{{ __('
                                    Tambah Role') }}</a> --}}
                                <button class="btn btn-primary mr-1" type="button" onclick="searchRolesDetail()">Cari
                                    Role</button>
                                <button class="btn btn-primary mr-1" type="button" onclick="del()">Hapus Role</button>
                                <button class="btn btn-primary mr-1" onclick="simpanData()" type="button">Simpan
                                    Perubahan</button>
                            </td>
                        </tr>
                    </table>
                    <table class="table-striped table" id="table" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">
                                    {{ __('NO') }}
                                </th>
                                <th class="text-center">{{ __('Menu') }}</th>
                                <th class="text-center">{{ __('Lihat') }}</th>
                                <th class="text-center">{{ __('Tambah') }}</th>
                                <th class="text-center">{{ __('Ubah') }}</th>
                                <th class="text-center">{{ __('Hapus') }}</th>
                                {{-- <th class="text-center">{{ __('Cabang') }}</th> --}}
                                {{-- <th>{{ __('Print') }}</th> --}}
                            </tr>
                        </thead>
                        <tbody class="dropRole">
                            {{-- --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')

<script>
    $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        function searchRolesDetail() {
            var idRoles = $('.level').val();
            if(idRoles == null || idRoles == ''){
                return swal("Pilih Hak Akses Terlebih Dahulu", {
                            icon: "warning",
                        });
            }
            $.ajax({
                url: "/master/roles/search-roles-detail?&id="+idRoles,
                type: "POST",
                processData: false,
                success: function(data) {
                    $('.dropRole').empty();

                    $.each(data.menu, function(index,value){

                    if(data.menu[index].view == 'on'){
                        var checkedView = 'checked';
                    }else{
                        var checkedView = '';
                    }

                    if(data.menu[index].edit == 'on'){
                        var checkedEdit = 'checked';
                    }else{
                        var checkedEdit = '';
                    }

                    if(data.menu[index].delete == 'on'){
                        var checkedDelete = 'checked';
                    }else{
                        var checkedDelete = '';
                    }

                    if(data.menu[index].create == 'on'){
                        var checkedCreate = 'checked';
                    }else{
                        var checkedCreate = '';
                    }

                    $('.dropRole').append(
                        '<tr>'+
                                '<td>'+(index+1)+'</td>'+
                                '<td><input type="hidden" value="'+data.menu[index].id+'" name="menu[]">'+data.menu[index].name+'</td>'+
                                '<td class="text-center">'+
                                    '<div class="form-group">'+
                                      '<div class="form-check">'+
                                        '<input class="form-check-input view" name="view[]" '+checkedView+' value="'+data.menu[index].id+'"  type="checkbox" id="defaultCheck1">'+
                                      '</div>'+
                                    '</div>'+
                                '</td>'+
                                '<td class="text-center">'+
                                    '<div class="form-group">'+
                                        '<div class="form-check">'+
                                          '<input class="form-check-input create" name="create[]"  '+checkedCreate+'  value="'+data.menu[index].id+'"  type="checkbox" id="defaultCheck1">'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                                '<td class="text-center">'+
                                    '<div class="form-group">'+
                                        '<div class="form-check">'+
                                          '<input class="form-check-input" name="edit[]" '+checkedEdit+' value="'+data.menu[index].id+'"  type="checkbox" id="defaultCheck1">'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                                '<td class="text-center">'+
                                    '<div class="form-group">'+
                                        '<div class="form-check">'+
                                          '<input class="form-check-input" name="delete[]" '+checkedDelete+' value="'+data.menu[index].id+'"  type="checkbox" id="defaultCheck1">'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                                // '<td class="text-center">'+
                                //     '<div class="form-group">'+
                                //         '<div class="form-check">'+
                                //           '<input class="form-check-input" name="branch[]" type="checkbox" id="defaultCheck1">'+
                                //         '</div>'+
                                //     '</div>'+
                                // '</td>'+
                            '</tr>'
                    );
                });

                },
            });
        }

        function simpanData() {
            var form = $(".form-data");    
            var formdata = new FormData(form[0]);
            $.ajax({
                url: "/master/roles/save-roles-detail/",
                type: "POST",
                data: formdata ? formdata : form.serialize(),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.status == 'success'){
                        swal("Data Telah Tersimpan", {
                            icon: "success",
                        });
                    }else{
                        swal("Data Tidak Tersimpan", {
                            icon: "error",
                        });
                    }
                }
            });
        }

        function del() {
            swal({
                title: "Apakah Anda Yakin?",
                text: "Aksi ini tidak dapat dikembalikan, dan akan menghapus data master Anda.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "/master/roles/role/"+idRoles,
                        type: "DELETE",
                        success: function () {
                            swal("Data master berhasil dihapus", {
                                icon: "success",
                            });
                            // location.reload();
                        },
                    });
                } else {
                    swal("Data master Anda tidak jadi dihapus!");
                }
            });
        }
</script>
@endsection