@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Sharing Profit'))
@section('titleContent', __('Sharing Profit'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Sharing Profit') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('sharing-profit.create') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Create Sharing Profit') }}</a>


    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Submited</th>
                    <th>date</th>
                    <th>payment date</th>
                    <th>Crew</th>
                    <th>Total</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal  fade exampleModal" tabindex="-1" role="dialog" id="exampleModal" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <div class="dropHereJournals"> --}}
                    <h6>Jurnal</h6>
                    <table class="table table-stripped table-bordered">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>D</th>
                            <th>K</th>
                        </tr>
                        <tbody class="dropHereJournals">

                        </tbody>
                    </table>

                 
                {{-- </div> --}}
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/finance/sharingProfitScript.js') }}"></script>
@endsection
