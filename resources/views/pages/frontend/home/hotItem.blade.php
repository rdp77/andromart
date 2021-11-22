@if($contents['home_hot_item'] == true)
@include('pages.frontend.tape', ['tapeName' => 'Hot Item'])
<section class="section section-height-3 bg-light border-0 m-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel owl-theme mb-0" data-plugin-options="{'responsive': {'0': {'items': 1}, '476': {'items': 1}, '768': {'items': 2}, '992': {'items': 4}, '1200': {'items': 4}}, 'autoplay': true, 'autoplayTimeout': 5000, 'dots': true}">
                    @foreach($homeHotItem as $row)
                    @php 
                        $harga = $row->prize - $row->discount;
                        $hasil_rupiah = "Rp " . number_format($harga,2,',','.');
                    @endphp
                    <div style="padding: 20px;">
                        <img class="img-fluid opacity-3" src="{{ asset('photo_product/'.$row->image) }}" alt="" style="height: 350px; object-fit: cover;">
                        <br />
                        <div style="border-left: 1px solid #999; padding-left: 10px;">
	                        <h3><b>{{ $row->name }}</b></h3>
	                        <h6 style="margin-top: -30px;">{{ $hasil_rupiah }}</h6>
                            <div style="float: right;">
                                <a class="btn btn-outline btn-primary text-1 font-weight-semibold text-uppercase px-2 btn-py-1 mb-3" style="margin-bottom: -10px;" href="{{ Route('frontendProductShowDetail', $row->id) }}">Selengkapnya</a>
                            </div>
                    	</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif