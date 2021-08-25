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
                        @php 
                        	use Illuminate\Support\Facades\Auth;
                        	$no = 1;
                        	$this_users_id = Auth::user()->id;
                        @endphp
                        @foreach($models as $rows)
	                        <tr>
	                          <td>{{ $no++ }}</td>
	                          <td>{{ $rows->name }}</td>
	                          <td>{{ $rows->date }}</td>
	                          <td>{{ $rows->title }}</td>
	                          @if($this_users_id == $rows->users_id)
		                          <td><a href="{{ route('notes.edit', $rows->notes_id) }}" class="btn btn-warning">Edit</a></td>
		                          <td>
                              <form action="{{ route('notes.destroy', $rows->notes_id) }}" method="POST">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <button class="btn btn-danger m-1">Delete</button>
                              </form>
                              </td>
		                      @endif
	                          <td><a href="{{ route('notes.show', $rows->notes_id) }}" class="btn btn-primary">Detail</a></td>
	                        </tr>
                        @endforeach
                      </table>
                    </div>
                  </div>
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
@endpush