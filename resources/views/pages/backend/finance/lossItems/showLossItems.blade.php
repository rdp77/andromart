@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Loss Items'))
@section('titleContent', __('Loss Items'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Service') }}</div>
<div class="breadcrumb-item active">{{ __('Loss Items') }}</div>
@endsection

@section('content')
@csrf
<form class="form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Data</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                          <table class="table table-striped">
                              <thead>
                                  <tr>
                                      <th class="text-center">Service</th>
                                      <th class="text-center">date</th>
                                      <th class="text-center">Customer</th>
                                      <th class="text-center">Total</th>
                                      {{-- <th class="text-center">Dibayarkan</th> --}}
                                  </tr>
                              </thead>
                              <tbody class="dropHere" style="border: none !important">
                                
                                @foreach ($data->LossItemsDetail as $el)
                                    <tr>
                                        <td>{{$el->Service->code}}</td>
                                        <td>{{ \Carbon\Carbon::parse($el->Service->date)->locale('id')->isoFormat('LL') }}</td>
                                        <td>{{$el->Service->customer_name}}</td>
                                        <td>{{number_format($el->total, 0, '.', ',')}}</td>
                                    </tr>
                                @endforeach

                              </tbody>
                              <tfoot>
                                  <tr>
                                      <th colspan="3">Total </th>
                                      <th class="dropHereTotal">{{number_format($data->total, 0, '.', ',')}}</th>
                                  </tr>
                              </tfoot>
                          </table>
                          <div class="dropHereTotalVal"></div>
                          <button type="button" class="btn btn-primary" onclick="backSharingProfit()"><i class="fas fa-save"></i> Kembali</button>
              
                      </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</form>
@endsection

@section('script')
<script>
    function backSharingProfit(params) {
        window.location = '{{route('loss-items.index')}}';
    }
</script>
@endsection
