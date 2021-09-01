@if($contents['home_tab'] == true)
<div class="container py-4 my-5">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12 col-lg-10">
            <div class="tabs tabs-bottom tabs-center tabs-simple custom-tabs-style-1 mt-2 mb-3">
                <ul class="nav nav-tabs mb-3">
                    @foreach($homeTab as $row)
                    <!-- active -->
                    <li class="nav-item active">
                        <a class="nav-link" href="#{{ $row->class }}" data-toggle="tab">
                            <span class="featured-boxes featured-boxes-style-6 p-0 m-0">
                                <span class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0">
                                    <span class="box-content p-0 m-0">
                                        <i class="icon-featured icon-bulb icons"></i>
                                    </span>
                                </span>
                            </span>
                            <p class="text-color-dark font-weight-bold mb-0 pt-2 text-2 pb-0">{{ $row->title }}</p>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    <!-- active -->
                    @foreach($homeTab as $row)
                    <div class="tab-pane active" id="{{ $row->class }}">
                        <div class="text-center">
                            {{ $row->description }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
    <div class="row">
        @foreach($homeTab as $row)
        <div class="col text-center">
            <a class="btn btn-outline btn-primary text-1 font-weight-semibold text-uppercase px-5 btn-py-2 mb-3" href="{{ $row->url }}">Learn More</a>
        </div>
        @endforeach
    </div>
</div>
@endif