@extends('layouts.frontend.default')
@section('title', 'Home')
@section('menu-active', 'home')
@section('content')
<div role="main" class="main">
    @include('pages.frontend.home.slider')
    @include('pages.frontend.home.tabContent')
    @include('pages.frontend.home.whoWeAre')
    @include('pages.frontend.home.testimonials')
    @include('pages.frontend.home.achievement')
    <hr class="opacity-6">
    @include('pages.frontend.home.vendors')
    <!-- @include('pages.frontend.home.porto') -->
</div>
@endsection
