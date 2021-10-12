@if($contents['home_service_unit'] == true)
<!-- section section-height-3  -->
<section class="bg-dark border-0 m-0">
@include('pages.frontend.tape', ['tapeName' => 'Service Unit'])
	<br />
    <div class="container">
        <div class="row">
        	<div class="col-lg-2"></div>
		    <div class="col-12 col-lg-8">
            	<div class="row">
            		<div class="col-12">
		                    <center><h3 style="color: white;">{{ __('Lacak Unit Service Anda') }}</h3></center>
            		</div>
	            	<div class="col-8">
		                <div class="form-group">
		                    <input type="text" name="name" id="nameText" class="form-control col-sm-12 filter_name" placeholder="Masukkan Kode Service">
		                </div>
	            	</div>
	            	<div class="col-4">
		                <a href="" id="hrefUrls" class="btn btn-primary mr-1" type="submit" onclick="show()">
		                	<!-- <i class="far fa-search"></i> -->
		                    {{ __('Cari Id Service') }}
		                </a>
	            	</div>
            	</div>
		    </div>
		    <div class="col-lg-2"></div>
		</div>
		<div class="row">
			@foreach($homeServiceUnit as $row)
				<div class="col-12 col-lg-3" style="text-align: center;">
					<img src="{{ asset($row->image) }}" style="width: 200px; height: 200px; object-fit: cover; margin-bottom: 10px;">
					<h3 style="color: white;">{{ $row->title }}</h3>
					<h3 style="color: #ed3b9d; margin-top: -30px;"><b>{{ $row->subtitle }}</b></h3>
				</div>
			@endforeach
		</div>
    </div>
</section>
@endif