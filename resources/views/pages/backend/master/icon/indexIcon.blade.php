@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Master Ikon'))
@section('titleContent', __('Ikon'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Ikon') }}</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
    	<div class="row">
    		@foreach($icon as $row)
    			<div class="col-2" style="margin-bottom: 50px;">
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
