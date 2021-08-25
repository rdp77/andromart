@extends('layouts.frontend.default')
@section('title', 'About')
@section('menu-active', 'about')
@section('content')
<div role="main" class="main">
    @include('pages.frontend.about.header')
    @include('pages.frontend.about.visionMission')
    @include('pages.frontend.about.achievement')
    @include('pages.frontend.about.leadership')
	@include('pages.frontend.about.clients')
</div>
@endsection