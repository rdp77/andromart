@extends('layouts.frontend.default')
@section('title', 'Services')
@section('menu-active', 'services')
@section('content')
<div role="main" class="main">
	@include('pages.frontend.services.slider')
	@include('pages.frontend.services.titleSlider')
	@include('pages.frontend.services.text')
	@include('pages.frontend.services.help')
	@include('pages.frontend.services.featured')
	@include('pages.frontend.services.innovation')
</div>
@endsection