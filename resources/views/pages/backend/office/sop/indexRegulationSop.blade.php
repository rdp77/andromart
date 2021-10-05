@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Peraturan'))
@section('titleContent', __('Peraturan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Peraturan') }}</div>
@endsection

@section('content')
<div class="section-body">
<!-- <h2 class="section-title">Articles</h2>
<p class="section-lead">This article component is based on card and flexbox.</p> -->
    <div class="row">
        @foreach($models as $row)
        <a href="/office/regulation/select-sop/{{ $row->id }}">
          <div class="col-12 col-md-4 col-lg-4">
            <article class="article article-style-c">
              <div class="article-header">
                <div class="article-image" data-background="{{ asset('assetsfrontend/img/andromart.png') }}">
                </div>
              </div>
              <div class="article-details">
                <!-- <div class="article-category"><a href="#">News</a> <div class="bullet"></div> <a href="#">Date</a></div> -->
                <div class="article-title">
                  <h2><a href="/office/regulation/select-sop/{{ $row->id }}">{{ $row->title }}</a></h2>
                </div>
                <?php $row->description ?>
                <div class="article-user">
                  <img alt="image" src="{{ asset('assets/img/avatar.png') }}">
                  <div class="article-user-details">
                    <div class="user-detail-name">
                      {{ $row->roleName }}
                    </div>
                    <div class="text-job">{{ $row->branchName }}</div>
                  </div>
                </div>
              </div>
            </article>
          </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/office/regulationScript.js') }}"></script>
@endsection
