@extends('layouts.frontend.default')
@section('title', 'Home')
@section('menu-active', 'home')
@section('content')
<div role="main" class="main">
    @include('pages.frontend.home.slider')
    @include('pages.frontend.home.tabContent')
    <!-- pages.frontend.home.tracking') -->
    @include('pages.frontend.home.serviceUnit')
    @include('pages.frontend.home.hotItem')
    @include('pages.frontend.home.whoWeAre')
    @include('pages.frontend.home.testimonials')
    @include('pages.frontend.home.achievement')
    <hr class="opacity-6">
    @include('pages.frontend.home.vendors')
    <!-- @include('pages.frontend.home.porto') -->
</div>
@endsection
