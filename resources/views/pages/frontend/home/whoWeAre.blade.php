<section class="section section-height-3 bg-color-grey-scale-1 border-top-0 m-0">
    <div class="container">
        <div class="row py-3 mb-2">
            <div class="col-lg-6 pr-5 appear-animation" data-appear-animation="fadeInRightShorter">
                <h2 class="font-weight-extra-bold text-color-dark text-6 mb-0">{{ $homeAboutUs->title }}</h2>
                <p class="font-weight-normal opacity-8 text-4 mb-3">{{ $homeAboutUs->subtitle }}</p>
                <div class="divider divider-primary divider-small divider-small-left">
                    <hr class="w-25">
                </div>
                <?php echo $homeAboutUs->description ?>

                <a class="text-dark font-weight-bold text-2" href="{{ $homeAboutUs->url }}">VIEW MORE<i class="fas fa-chevron-right text-2 pl-2"></i></a>
            </div>
            <div class="col-lg-6 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200">
                <div class="row">
                    <div class="col">
                        <p class="font-weight-bold text-color-dark text-4 mt-4 pt-3">Alasan Utama Mempekerjakan Kami</p>
                        <div class="divider divider-primary divider-small divider-small-left">
                            <hr class="w-25">
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php $delay = 100 @endphp
                    @foreach($homeHireUs as $row)
                    <div class="col-sm-6">
                        <div class="feature-box align-items-center mb-2" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="{{ $delay+=100 }}">
                            <div class="feature-box-icon">
                                <i class="{{ $row->icon }} icons"></i>
                            </div>
                            <div class="feature-box-info">
                                <p class="opacity-9 mb-0">{{ $row->title }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>