@extends('layouts.frontend.default')
@section('title', 'Work')
@section('menu-active', 'work')
@section('content')
<div role="main" class="main">
	@include('pages.frontend.work.header')
	@include('pages.frontend.work.activity')
</div>
@endsection