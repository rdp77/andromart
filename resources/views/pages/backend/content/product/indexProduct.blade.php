@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Product'))
@section('titleContent', __('Product'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Kategori Product') }}</div>
@endsection

@section('content')
<!-- @include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification') -->
<div class="card">
    <div class="card-header">
        <a href="{{ route('product.created', $id) }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Product') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">{{ __('NO') }}</th>
                    <th>{{ __('Nama') }}</th>
                    <th>{{ __('Gambar') }}</th>
                    <th colspan="2">{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    use Illuminate\Support\Facades\Crypt;
                    $i = 1;
                @endphp
                @foreach($product as $row)
                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $row->name }}</td>
                    <td><img src="{{ asset('photo_product/'.$row->image) }}" style="max-width: 100px; height: 100px; object-fit: cover;"></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                    data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('product.edit', $row->id) }}">
                                    <i class="far fa-edit"></i> Edit
                                </a>
                                <a class="dropdown-item" href="{{ route('product.deleted', $row->id) }}">
                                    <i class="far fa-trash-alt"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/content/productScript.js') }}"></script>
@endsection
