@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Notulensi'))
@section('titleContent', __('Notulen'))
@section('breadcrumb', __('Tanggal ').date('d-M-Y'))

@section('content')
<!-- @include('layouts.backend.components.notification') -->
		  <div class="section-body">
            <h2 class="section-title">Users</h2>
            <p class="section-lead">01 Januari 2020</p>
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-7">
              	<div class="card" style="border: 1px #aaa solid;">
		          <div class="card-header">
		            <h4>Form Notulen</h4>
		          </div>
		          <form method="POST" class="form-data" action="{{ route('save notes') }}">
		    	  @csrf
		          <div class="card-body">
		            <div class="form-group row mb-4">
		              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
		              <div class="col-sm-12 col-md-7">
		                <input type="text" class="form-control" name="title">
		              </div>
		            </div>
		            <div class="form-group row mb-4">
		              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
		              <div class="col-sm-12 col-md-7">
		                <textarea class="summernote" name="description"></textarea>
		              </div>
		            </div>
		            <div class="form-group row mb-4">
		              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto</label>
		              <div class="col-sm-12 col-md-7">
		                <div class="custom-file">
		                  <input type="file" name="photo" class="custom-file-input" id="site-logo">
		                  <label class="custom-file-label">Pilih Foto</label>
		                </div>
			      	  </div>
			        </div>
		            <div class="form-group row mb-4">
		              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
		              <div class="col-sm-12 col-md-7">
		                <input type="submit" class="btn btn-primary" value="kirim">
		              </div>
		            </div>
		          </div>
		          </form>
		        </div>
              </div>
              <div class="col-12 col-md-12 col-lg-5">
              	<div class="card" style="border: 1px #aaa solid;">
		          <div class="card-header">
		            <h4>Hasil Notulen</h4>
		          </div>
		          <div class="card-body p-0" id="hasil-notulen">
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tr>
                          <th>#</th>
                          <th>Nama</th>
                          <th>Tanggal</th>
                          <th>Judul</th>
                          <th>Action</th>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>Irwansyah Saputra</td>
                          <td>2017-01-09</td>
                          <td>Step Sis</td>
                          <td><a href="{{ route('detail notes') }}" class="btn btn-warning">Edit</a></td>
                          <td><a href="{{ route('detail notes') }}" class="btn btn-danger">Delete</a></td>
                          <td><a href="{{ route('detail notes') }}" class="btn btn-primary">Detail</a></td>
                        </tr>
                      </table>
                    </div>
                  </div>
		      	</div>
		  	  </div>
            </div>
          </div>
  <div class="section-body">
    <!-- <h2 class="section-title">Editor</h2>
    <p class="section-lead">WYSIWYG editor and code editor.</p> -->
    <div class="row">
      <div class="col-12">
        <d
      </div>
    </div>
  </div>
@endsection