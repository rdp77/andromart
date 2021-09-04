@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | ')."$contentType->name")
@section('titleContent', "$contentType->name")
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ $contentType->name }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
@php use Illuminate\Support\Facades\Crypt; @endphp
<div class="card">
    <div class="card-header">
    	@if($contentType->status == 1)
        <a href="{{ route('contentCreates', Crypt::encryptString($contentType->id)) }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>Tambah {{ $contentType->name }}</a>
        @endif
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">{{ __('NO') }}</th>
                    @if($contentType->column_1 == 1)<th>Title</th>@endif
                    @if($contentType->column_2 == 1)<th>Subtitle</th>@endif
                    @if($contentType->column_3 == 1)<th>Description</th>@endif
                    @if($contentType->column_4 == 1)<th>Image</th>@endif
                    @if($contentType->column_5 == 1)<th>Icon</th>@endif
                    @if($contentType->column_6 == 1)<th>Url</th>@endif
                    @if($contentType->column_7 == 1)<th>Class</th>@endif
                    @if($contentType->column_8 == 1)<th>Position</th>@endif
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1 @endphp
            	@foreach($content as $row)
	            	<tr>
                        <td>{{ $no++ }}</td>
	                    @if($contentType->column_1 == 1)<td>{{ $row->title }}</td>@endif
	                    @if($contentType->column_2 == 1)<td>{{ $row->subtitle }}</td>@endif
	                    @if($contentType->column_3 == 1)<td>{{ $row->description }}</td>@endif
	                    @if($contentType->column_4 == 1)<td><img class="img-fluid" src="{{ asset($row->image) }}"></td>@endif
	                    @if($contentType->column_5 == 1)<td>{{ $row->icon }}</td>@endif
	                    @if($contentType->column_6 == 1)<td>{{ $row->url }}</td>@endif
	                    @if($contentType->column_7 == 1)<td>{{ $row->class }}</td>@endif
	                    @if($contentType->column_8 == 1)<td>{{ $row->position }}</td>@endif
                        <td><a class="dropdown-item" href="{{ route('contents.edit', Crypt::encryptString($row->id)) }}">Ubah</a></td>
	            	</tr>
            	@endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<!-- <script src="{{ asset('assets/pages/content/contentScript.js') }}"></script> -->
@endsection
