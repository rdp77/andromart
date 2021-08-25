@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Notulensi'))
@section('titleContent', __('Notulen'))
@section('breadcrumb', __('Tanggal ').date('d-M-Y'))

@push('custom-css')
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@endpush

@section('content')
<!-- @include('layouts.backend.components.notification') -->
      <div class="section-body">
            <h2 class="section-title">Users</h2>
            <p class="section-lead">01 Januari 2020</p>
            <div class="row mt-sm-4">
              <div class="col-12">
                <div class="card" style="border: 1px #aaa solid;" id="form-notes">
              <div class="card-header">
                <h4>Edit Notes</h4>
              </div>
              <form action="{{ route('notes.update',$models->id) }}" method="POST" class="form-data" enctype="multipart/form-data">
                @csrf
                @method('PUT')
              <div class="card-body">
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-2 col-lg-1">Judul</label>
                  <div class="col-sm-12 col-md-10 col-lg-11">
                    <input type="text" class="form-control" name="title" value="{{ $models->title }}">
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-2 col-lg-1">Deskripsi</label>
                  <div class="col-sm-12 col-md-10 col-lg-11">
                    <textarea class="summernote" name="description">{{ $models->description }}</textarea>
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-2 col-lg-1">Foto</label>
                  <div class="col-sm-12 col-md-10 col-lg-11">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="site-logo" name="photo[]" multiple>
                      <!-- <input type="file" name="photo" class="custom-file-input"> -->
                      <label class="custom-file-label">Pilih Foto</label>
                    </div>
                  </div>
                </div>>
                <!-- <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-2 col-lg-1">Foto Sebelumnya</label>
                  <div class="col-sm-12 col-md-10 col-lg-11">
                    @php $no = 1 @endphp
                    @foreach($modelsPhoto as $rows)
                      <img src="{{ URL::to($rows->photo) }}" style="width: 100px; height: 100px; object-fit: cover; margin: 10px;" data-confirm="Peringatan?|Apakah kamu ingin menghapus?" data-confirm-yes="delete({{ route('notesPhotoDelete', $rows->id) }});">
                    @endforeach
                  </div>
                </div> -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-2 col-lg-1"></label>
                  <div class="col-sm-12 col-md-10 col-lg-11">
                    <input type="submit" class="btn btn-primary" value="Edit">
                  </div>
                </div>
              </div>
              </form>
            </div>
              </div>
            </div>
          </div>
@endsection
@push('custom-js')
  <!-- General JS Scripts -->
  <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="assets/assets/js/stisla.js"></script> -->

  <!-- JS Libraies -->
  <!-- <script src="assets/node_modules/summernote/dist/summernote-bs4.js"></script>
  <script src="assets/node_modules/codemirror/lib/codemirror.js"></script>
  <script src="assets/node_modules/codemirror/mode/javascript/javascript.js"></script>
  <script src="assets/node_modules/selectric/public/jquery.selectric.min.js"></script> -->

  <!-- Template JS File -->
  <!-- <script src="assets/assets/js/scripts.js"></script>
  <script src="assets/assets/js/custom.js"></script> -->

  <!-- Page Specific JS File -->
  <script type="text/javascript">
    function delete(url) {
      window.open(url, '_blank').focus();
    }
  </script>
@endpush