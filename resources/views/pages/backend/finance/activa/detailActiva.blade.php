@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Detail Aktiva / Penyusutan'))
@section('titleContent', __('Detail Aktiva / Penyusutan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
    <div class="breadcrumb-item active">{{ __(' Aktiva / Penyusutan') }}</div>
    <div class="breadcrumb-item active">{{ __('Detail  Aktiva / Penyusutan') }}</div>
@endsection

@section('content')
    <form>
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Akumulasi penyusutan</h4>
                    </div>
                    @php
                        $totalAc = $data->total_early_depreciation
                    @endphp
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-md table-bordered">
                                <thead>
                                    <tr>
                                        <th>Periode</th>
                                        <th>Cabang</th>
                                        <th>Jurnal</th>
                                        <th>Akun</th>
                                        <th>Beban Penyusutan</th>
                                        <th>Akumulasi Penyusutan</th>
                                        <th>Nilai Sisa/Buku</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Penyusutan Awal</td>
                                        <td>{{ $data->branch->name }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{ number_format($data->total_depreciation, 0, '.', ',') }}</td>
                                        <td>0</td>
                                        <td>{{ number_format($data->total_early_depreciation, 0, '.', ',') }}</td>
                                    </tr>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @for ($i = 0; $i < count($data->ActivaDetail); $i++)
                                        <tr>
                                            <td>{{$data->ActivaDetail[$i]->period_depreciation}}</td>
                                            <td>{{ $data->ActivaDetail[$i]->branch->name }}</td>
                                            <th><u onclick="jurnal('{{$data->ActivaDetail[$i]->Journals->code}}')" style="color:blue;cursor:pointer">{{ $data->ActivaDetail[$i]->Journals->code }}</u></th>
                                            <td>{{ $data->ActivaDetail[$i]->AccountDepreciation->name }}</td>
                                            <td>{{ number_format($data->ActivaDetail[$i]->total_depreciation, 0, '.', ',') }}</td>
                                            <td>{{ number_format($total+=$data->ActivaDetail[$i]->total_depreciation, 0, '.', ',') }}</td>
                                            <td>{{ number_format($totalAc-=$data->ActivaDetail[$i]->total_depreciation, 0, '.', ',') }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('code') }}</label><code>*</code>
                                <h5>{{ $data->code }}</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address"
                                    class="control-label">{{ __('Barang / lokasi') }}<code>*</code></label>
                                @if ($data->with_items == 'Y')
                                    <h5>{{ $data->itemsRel->name }} / {{ $data->location }}</h5>
                                @else
                                    <h5>{{ $data->items }} / {{ $data->location }}</h5>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="email" class="control-label">{{ __('Penanggung Jawab') }}</label><code>*</code>
                                <h5>{{ $data->UserResponsible->name }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('Cabang') }}</label><code>*</code>
                                <h5>{{ $data->branch->name }}</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('Deskripsi') }}</label><code>*</code>
                                <h5>{{ $data->description }}</h5>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('Tgl Perolehan') }}</label><code>*</code>
                                <h5>{{ date('d F Y', strtotime($data->date_acquisition)) }}</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('Bulan Selesai') }}</label><code>*</code>
                                <h5>{{ date('F Y', strtotime($data->date_finished)) }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email"
                                    class="control-label">{{ __('Nilai Perolehan') }}</label><code>*</code>
                                <h5>Rp. {{ number_format($data->total_acquisition, 0, '.', ',') }}</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email"
                                    class="control-label">{{ __('Nilai Awal Penyusutan') }}</label><code>*</code>
                                <h5>Rp. {{ number_format($data->total_early_depreciation, 0, '.', ',') }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email"
                                    class="control-label">{{ __('Nilai Penyusutan') }}</label><code>*</code>
                                <h5>Rp. {{ number_format($data->total_depreciation, 0, '.', ',') }}</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label">{{ __('Status') }}</label><code>*</code>
                                <h5>{{ $data->status }}</h5>
                            </div>
                        </div>
                      
                      
                    </div>
                 
                </div>

            </div>

    </form>

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
    
                    
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function changeSelectItems(params) {
            var with_items = $('#with_items').val();

            if (with_items == 'Y') {
                $('.hiddenItems').css('display', 'none');
                $('.hiddenItemsId').css('display', 'block');
            } else {
                $('.hiddenItems').css('display', 'block');
                $('.hiddenItemsId').css('display', 'none');
            }
        }

        function appendValue(params) {
            $('#estimate_age').val($('#activa_group_id').find(':selected').data('estimate'));
            $('#depreciation_rate').val($('#activa_group_id').find(':selected').data('depreciation'));

            calc();
        }
        
    </script>
    <script src="{{ asset('assets/pages/master/activaScript.js') }}"></script>
@endsection
