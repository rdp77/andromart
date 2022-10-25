@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Transaksi Aktiva / Penyusutan'))
@section('titleContent', __('Transaksi Aktiva / Penyusutan'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
    <div class="breadcrumb-item active">{{ __(' Aktiva / Penyusutan') }}</div>
    <div class="breadcrumb-item active">{{ __('Transaksi  Aktiva / Penyusutan') }}</div>
@endsection

@section('content')
    <form class="form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">


                    <div class="card-body">
                        <div class="text-center">
                            <h5>ANDROMART INDONESIA</h5>
                            <h5>TRANSAKSI PENYUSUTAN INVENTARIS</h5>
                            <h5>PERIODE : {{ date('F Y') }}</h5>
                        </div>
                        <br>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-md table-bordered">
                                    <thead>
                                        <tr>
                                            <th>kode</th>
                                            <th>Barang</th>
                                            <th>Cabang</th>
                                            <th>Lokasi</th>
                                            <th>Deskripsi</th>
                                            <th>Akun Penyusutan</th>
                                            <th>Akun Akumulasi</th>
                                            <th>Jenis Asset / Gol. Akt</th>
                                            <th>Tgl Perolehan</th>
                                            <th>Nilai Perolehan</th>
                                            <th>Nilai Penyusutan</th>
                                            <th>Nilai Akumulasi</th>
                                            <th>Nilai Buku</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $checkSave = 0;
                                        @endphp
                                        @foreach ($data as $index => $data)
                                            <tr class="removeTr">
                                                <th>{{ $data->code }}</th>
                                                <td>
                                                    @if ($data->with_items == 'Y')
                                                        {{ $data->ItemsRel->name }}
                                                    @else
                                                        {{ $data->items }}
                                                    @endif
                                                </td>
                                                <td>{{ $data->Branch->name }}</td>
                                                <td>{{ $data->location }}</td>
                                                <td>{{ $data->description }}</td>
                                                <td>{{ $data->AccountDepreciation->code }}<br>
                                                    {{ $data->AccountDepreciation->name }}</td>
                                                <td>{{ $data->AccountAccumulation->code }}<br>
                                                    {{ $data->AccountAccumulation->name }}</td>
                                                <td>{{ $data->Asset->name }}
                                                    <hr> {{ $data->ActivaGroup->name }}
                                                </td>
                                                <td> {{ date('d F Y', strtotime($data->date_acquisition)) }}</td>
                                                <th>Rp. {{ number_format($data->total_acquisition, 0, '.', ',') }}</th>
                                                <th>Rp. {{ number_format($data->total_depreciation, 0, '.', ',') }}</th>
                                                <th>Rp.
                                                    {{ number_format($data->accumulation_depreciation + $data->total_depreciation, 0, '.', ',') }}
                                                </th>
                                                <th>Rp.
                                                    {{ number_format($data->remaining_depreciation - $data->total_depreciation, 0, '.', ',') }}
                                                </th>
                                            </tr>

                                            <input type="hidden" name="code[]" value="{{ $data->code }}">
                                            <input type="hidden" name="id[]" value="{{ $data->id }}">
                                            <input type="hidden" name="branch_id[]" value="{{ $data->branch_id }}">
                                            <input type="hidden" name="account_depreciation_id[]"
                                                value="{{ $data->AccountDepreciation->id }}">
                                            <input type="hidden" name="account_accumulation_id[]"
                                                value="{{ $data->AccountAccumulation->id }}">
                                            <input type="hidden" name="account_depreciation_code[]"
                                                value="{{ $data->AccountDepreciation->code }}">
                                            <input type="hidden" name="account_accumulation_code[]"
                                                value="{{ $data->AccountAccumulation->code }}">
                                            <input type="hidden" name="total_depreciation[]"
                                                value="{{ $data->total_depreciation }}">
                                            <input type="hidden" name="period_depreciation[]" value="{{ date('Y-m') }}">
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <code>*Cek ulang serta Simak data dengan teliti dan rinci, agar tidak terjadi salah data. </code>
                        <br>
                        <br>
                        @if ($checkSave == 0)
                            <button class="btn btn-primary mr-1" type="button"
                                onclick="save()">{{ __('Simpan Data Penyusutan') }}</button>
                        @else
                            <button class="btn btn-danger mr-1" type="button" disabled
                                onclick="save()">{{ __('TIDAK DIPERBOLEHKAN MENYIMPAN') }}</button>
                        @endif

                        <a class="btn btn-outline" href="javascript:window.history.go(-1);">{{ __('Kembali') }}</a>
                    </div>
                </div>
            </div>
    </form>


@endsection
@section('script')
    <script>
        function save() {
            swal({
                title: "Apakah Anda Yakin?",
                text: "Aksi ini tidak dapat dikembalikan, dan akan menyimpan data Anda.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willSave) => {
                if (willSave) {
                    $.ajax({
                        url: "/finance/activa/activa/store-depreciation",
                        data: $(".form-data").serialize(),
                        type: "POST",
                        success: function(data) {
                            if (data.status == "success") {
                                swal(data.message, {
                                    icon: "success",
                                });
                                location.reload();
                            }
                        },
                        error: function(data) {
                            // edit(id);
                        },
                    });
                } else {
                    swal("Dibatalkan !");
                }
            });
        }
        
     
    </script>
    <script src="{{ asset('assets/pages/master/activaScript.js') }}"></script>
@endsection
