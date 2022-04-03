@extends('layouts.backend.default')
@section('title', __('pages.title') . __(' | Update Form Service'))
@section('titleContent', __('Update Form Service'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
    <div class="breadcrumb-item active">{{ __('Update Form Service') }}</div>
@endsection

@section('content')
    {{-- @include('pages.backend.components.filterSearch') --}}
    @include('layouts.backend.components.notification')
    @csrf
    <form class="form-data">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <h2 class="section-title">form </h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group col-12 col-md-12 col-lg-12">
                                    <div class="d-block">
                                        <label for="serviceId"
                                            class="control-label">{{ __('Service Code') }}<code>*</code></label>
                                    </div>
                                    <select class="select2 serviceId" name="serviceId" onchange="choseService()">
                                        <option value="">- Select -</option>
                                        @foreach ($data as $element)
                                            <option value="{{ $element->id }}">[{{ $element->code }}]
                                                {{ $element->customer_name }} - {{ $element->Brand->name }}
                                                {{ $element->Type->name }} <span><strong>( {{ $element->work_status }}
                                                        )</span></strong></option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="hiddenFormUpdate" style="display: none">
                                    <br>
                                    <h6 style="color: #6777ef">Update Status Pengerjaan</h6>
                                    <br>
                                    <div class="form-group col-12 col-md-12 col-lg-12">
                                        <div class="d-block">
                                            <label for="status"
                                                class="control-label">{{ __('Status') }}<code>*</code></label>
                                        </div>
                                        <select class="select2 status" name="status" onchange="changeStatusService()">
                                            <option selected value="">- Select -</option>
                                            <option value="Proses">Proses</option>
                                            <option value="Mutasi">Mutasi</option>
                                            <option value="Selesai">Selesai</option>
                                            <option value="Diambil">Sudah Diambil</option>
                                            {{-- <option value="Batal">Batal</option> --}}
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-12 col-lg-12 technicianFields"
                                        style="display: none">
                                        <div class="d-block">
                                            <label for="technicianId"
                                                class="control-label">{{ __('Teknisi') }}<code>*</code></label>
                                        </div>
                                        <select class="select2 technicianId" name="technicianId">
                                            <option value="">- Select -</option>
                                            @foreach ($employee as $element)
                                                <option value="{{ $element->id }}">{{ $element->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-12 col-lg-12">
                                        <label for="description">{{ __('Deskripsi') }}<code>*</code></label>
                                        <input id="description" type="text" class="form-control description"
                                            name="description">
                                    </div>
                                    <button class="btn btn-primary ml-3" type="button" onclick="updateStatusService()"><i
                                            class="far fa-save"></i> {{ __('Update Status') }}</button>
                                </div>
                            </div>
                        </div>
                        <h2 class="section-title">Tracking Service</h2>
                        <div class="activities">

                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <h2 class="section-title">Ambil Foto</h2>
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <div id="my_camera"></div>
                            <br />
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <input type=button class="btn btn-primary" value="Take Snapshot"
                                        onClick="take_snapshot()">
                                    <input type="hidden" name="image" class="image-tag">
                                </div>
                                <div class="form-group col-md-3">
                                    <button class="btn btn-primary" type="button" data-toggle="modal"
                                        data-target="#exampleModal">Lihat Gambar</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal fade" tabindex="1" role="dialog" id="exampleModal" aria-hidden="true"
                    style="display: none;">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Gambar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{-- <p>Modal body text goes here.</p> --}}
                                <div id="results"></div>
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </form>
@endsection
@section('script')
    <script src="{{ asset('assets/pages/transaction/serviceScript.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <style>
        .modal-backdrop {
            position: relative !important;
        }

    </style>
    <script language="JavaScript">
        $(document).ready(function() {
            // var constraints = {
                // video: true,
                // facingMode: "environment"
            // };
            Webcam.set({
                width: 700,
                height: 550,
                image_format: 'jpeg',
                jpeg_quality: 500
            });

            Webcam.attach('#my_camera');
        });

        function take_snapshot() {
            swal('Berhasil Mengambil Foto', {
                icon: "success",
            });
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);

                document.getElementById('results').innerHTML =
                    '<img name="image" id="sortpicture" class="image"  style="width: 100 % !important;height: auto!important;min - width: 100 px; min - height: 100 px;" src="' + data_uri + '"/>';
            });

        }
    </script>
@endsection
