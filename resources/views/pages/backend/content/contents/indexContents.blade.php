@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Content'))
@section('titleContent', __('Content'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Content') }}</div>
@endsection

@section('content')
<!-- @include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification') -->
<div class="card">
    <!-- <div class="card-header">
        <a href="{{ route('contents.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Cabang') }}</a>
    </div> -->
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">{{ __('NO') }}</th>
                    <th>{{ __('Konten') }}</th>
                    <th colspan="2">{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    use Illuminate\Support\Facades\Crypt;
                    $i = 1;
                @endphp
                @foreach($content as $row)
                <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{{ $row->name }}</td>
                    <td><a class="dropdown-item" href="{{ route('contents.show', Crypt::encryptString($row->id)) }}">Lihat</a></td>
                    @if($row->active == 1)
                    <td>
                        <a class="dropdown-item" href="contents/active/{{ $row->id }}/0">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                    @else
                    <td>
                        <a class="dropdown-item" href="contents/active/{{ $row->id }}/1">
                            <i class="fas fa-eye-slash"></i>
                        </a>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
@endsection
