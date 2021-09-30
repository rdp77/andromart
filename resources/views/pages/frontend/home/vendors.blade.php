@if($contents['home_vendor'] == true)
<section class="section section-height-3 bg-light border-0 m-0">
    <div class="container">
        <h3> Vendors :</h3>
        <div class="row">
            <div class="col">
                <div class="owl-carousel owl-theme mb-0" data-plugin-options="{'responsive': {'0': {'items': 1}, '476': {'items': 1}, '768': {'items': 5}, '992': {'items': 7}, '1200': {'items': 7}}, 'autoplay': true, 'autoplayTimeout': 3000, 'dots': false}">
                    @foreach($homeVendor as $row)
                    <div>
                        <a href="{{ asset($row->image) }}" target="_blank"><img class="img-fluid opacity-5" src="{{ asset($row->image) }}" alt=""></a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif