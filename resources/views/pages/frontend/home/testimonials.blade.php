<section class="section section-height-3 section-dark section-text-light section-no-border m-0 appear-animation" data-appear-animation="fadeIn">
    <div class="container my-4">
        @if($contents['home_testimonial_title'] == true)
        <div class="row justify-content-center pb-3 mb-4">
            <div class="col-lg-6 text-center appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
                <h2 class="font-weight-bold text-6 mb-0">{{ $homeTestimonialTitle->title }}</h2>
                <p class="font-weight-normal opacity-4 text-4 mb-3">{{ $homeTestimonialTitle->subtitle }}</p>
                <div class="divider divider-primary divider-small divider-small-center">
                    <hr class="w-25">
                </div>
            </div>
        </div>
        @endif
        @if($contents['home_testimonial'] == true)
        <div class="row justify-content-center">
            @foreach($homeTestimonial as $row)
            <!-- mb-lg-0 -->
            <div class="col-md-8 col-lg-4 mb-5 mb-lg-0 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="300">
                <div class="testimonial testimonial-style-2 testimonial-with-quotes testimonial-remove-right-quote mb-0">
                    <div class="testimonial-author">
                        <img src="{{ asset($row->image) }}" class="img-fluid rounded-circle mb-0" alt="">
                    </div>
                    <blockquote>
                        <p class="px-xl-2 mb-0"><?php echo $row->description; ?></p>
                    </blockquote>
                    <div class="testimonial-author">
                        <p><strong class="text-color-light opacity-10 text-4">{{ $row->title }}</strong></p>
                        <p class="text-2 opacity-8">{{ $row->subtitle }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>