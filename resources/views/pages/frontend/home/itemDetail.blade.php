@extends('layouts.frontend.default')
@section('title', 'Product')
@section('menu-active', 'home')
@section('content')
<div role="main" class="main">
    @include('pages.frontend.home.slider')
    <div class="container py-4 my-5">
        <div class="row">
            <div class="col-12">
                <h3>{{ $content->title }}</h3>
                <h4>{{ $content->subtitle}}</h4>
            </div>
            <div class="col-12 col-lg-5">
                <img class="img-fluid opacity-3" src="{{ asset($content->image) }}" alt="">
            </div>
            <div class="col-12 col-lg-7"><?php echo $content->description ?></div>
        </div>
    </div>
</div>
@endsection
