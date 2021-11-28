<div style="height: 100px;"></div>
<div role="main" class="main shop py-4">
	<div class="container">

		<div class="masonry-loader masonry-loader-showing">
			<div class="row products product-thumb-info-list" data-plugin-masonry data-plugin-options="{'layoutMode': 'fitRows'}">
			@foreach($itemProduct as $row)
				@php 
					$harga = $row->prize - $row->discount;
					$harga_rupiah = "Rp " . number_format($row->prize,2,',','.');
					$hasil_rupiah = "Rp " . number_format($harga,2,',','.');
				@endphp
				<div class="col-12 col-sm-6 col-lg-3 product">
					<span class="product-thumb-info border-0">
						<a href="{{ Route('frontendProductShowDetail', $row->id) }}" class="add-to-cart-product bg-color-primary">
							<span class="text-uppercase text-1">Lihat</span>
						</a>
						<a href="{{ Route('frontendProductShowDetail', $row->id) }}">
							<span class="product-thumb-info-image">
								<img alt="" class="img-fluid" src="{{ asset('photo_product/1.jpg') }}">
							</span>
						</a>
						<span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
							<a href="shop-product-sidebar-left.html">
								<h4 class="text-4 text-primary">{{ $row->name }}</h4>
								<span class="price">
									@if($row->discount != 0)
										<del><span class="amount">{{ $harga_rupiah }}</span></del><br />
									@endif
									<ins><span class="amount text-dark font-weight-semibold">{{ $hasil_rupiah }}</span></ins>
								</span>
							</a>
						</span>
					</span>
				</div>
			@endforeach
			</div>
			<div class="row">
				<div class="col-12">
			        <div class="col text-center">
			            <a class="btn btn-outline btn-primary text-1 font-weight-semibold text-uppercase px-5 btn-py-2 mb-3" href="{{ Route('frontendProductShow', [$id, $sort+1]) }}">Loadmore</a>
			        </div>
					<!-- <ul class="pagination float-right">
						<li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
						@for($i = 1; $i <= $itemProductRound; $i++)
							@if($i == $sort)
								<li class="page-item active"><a class="page-link" href="{{ Route('frontendProductShow', [$id, $i]) }}">{{ $i }}</a></li>
							@else
								<li class="page-item"><a class="page-link" href="{{ Route('frontendProductShow', [$id, $i]) }}">{{ $i }}</a></li>
							@endif
						@endfor
						<a class="page-link" href="#"><i class="fas fa-angle-right"></i></a>
					</ul> -->
				</div>
			</div>
		</div>

	</div>

</div>