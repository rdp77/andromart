@if($contents['home_tab'] == true)
<div class="container py-4 my-5">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12 col-lg-10">
            <div class="tabs tabs-bottom tabs-center tabs-simple custom-tabs-style-1 mt-2 mb-3">
                <ul class="nav nav-tabs mb-3">
                    @php $i = 0; @endphp
                    @foreach($homeTab as $row)
                    <li class="nav-item @if($i == 0) active @endif">
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
                    @php $i++ @endphp
                    @endforeach
                </ul>
                <div class="tab-content">
                    <!-- active -->
                    @php $j = 0; @endphp
                    @foreach($homeTab as $row)
                    <div class="tab-pane @if($j == 0) active @endif" id="{{ $row->class }}">
                        <div class="text-center">
                            {{ $row->description }}
                            <!-- {{ $row->class }} -->
                        </div>
                    </div>
                    @php $j++ @endphp
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <a class="btn btn-outline btn-primary text-1 font-weight-semibold text-uppercase px-5 btn-py-2 mb-3" href="/services">Learn More</a>
        </div>
    </div>
</div>
@endif