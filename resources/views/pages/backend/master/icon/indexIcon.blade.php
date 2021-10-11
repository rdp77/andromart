@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Ikon'))
@section('titleContent', __('Ikon'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Ikon') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('item.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Ikon') }}</a>
    </div>
    <div class="card-body">
    	<div class="row">
    		@foreach($icon as $row)
    			<div class="col-2" style="border: 1px #777 solid; margin: 2px;">
    				<center>
    					<div><i class="{{ $row->icon }}" style="font-size: 50px;"></i></div>
    					<div>{{ $row->icon }}</div>
    				</center>
    			</div>
    		@endforeach
    	</div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/master/itemScript.js') }}"></script>
@endsection
