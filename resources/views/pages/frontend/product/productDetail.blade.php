@extends('layouts.frontend.default')
@section('title', 'Home')
@section('menu-active', 'product')
@section('content')
<style type="text/css">
    .imageShop {
        max-width: 100px;
        max-height: 100px;
        margin:  10px;
    }
</style>
<div style="height: 100px;"></div>
<div role="main" class="main">
    <div role="main" class="main shop py-4">

        <div class="container">

            <div class="row">
                <div class="col-lg-6">

                    <img alt="" class="img-fluid" src="{{ asset('photo_product/1.jpg') }}">

                </div>
                <div class="col-lg-6">
                    <div class="summary entry-summary">
                        @php 
                            $harga = $itemProduct->prize - $itemProduct->discount; 
                            $hasil_rupiah = "Rp " . number_format($harga,2,',','.');
                            $harga_rupiah = "Rp " . number_format($itemProduct->prize,2,',','.');
                        @endphp
                        <h1 class="mb-0 font-weight-bold text-7">{{ $itemProduct->name }}</h1>
                        <h2 class="mb-0 text-7">Harga : {{ $hasil_rupiah }}</h2>
                        @if($itemProduct->discount != 0)
                            <del><span class="amount">{{ $harga_rupiah }}</span></del><br />
                        @endif

                        <div class="pb-0 clearfix">
                            <div title="Rated 3 out of 5" class="float-left">
                                <input type="text" class="d-none" value="3" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'primary', 'size':'xs'}">
                            </div>

                            <!-- <div class="review-num">
                                <span class="count" itemprop="ratingCount">2</span> reviews
                            </div> -->
                        </div>

                        <p class="price">
                            <span class="amount"></span>
                        </p>
                        <?= $itemProduct->detail ?>
                        <!-- <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus nibh sed elimttis adipiscing. Fusce in hendrerit purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus nibh sed elimttis adipiscing. Fusce in hendrerit purus. </p> -->

                        <!-- <div class="product-meta">
                            <span class="posted-in">Categories: <a rel="tag" href="#">Accessories</a>, <a rel="tag" href="#">Bags</a>.</span>
                        </div> -->
                    </div>
                     <!-- style="position: absolute; bottom: 10px;" -->
                     <br /><br /><br />
                    <div>
                        <h6>Temukan kami di: </h6>
                        <a href="https://api.whatsapp.com/send/?phone=6289662425357&text&app_absent=0">
                            <img class="imageShop" src="https://assets.stickpng.com/images/5ae21cc526c97415d3213554.png">
                        </a>
                        @if($itemProduct->tokopedia != null)
                            <a href="{{ $itemProduct->tokopedia }}">
                                <img class="imageShop" src="https://ecs7.tokopedia.net/assets-tokopedia-lite/v2/zeus/production/e5b8438b.svg">
                            </a>
                        @endif
                        @if($itemProduct->shopee != null)
                            <a href="{{ $itemProduct->shopee }}">
                                <img class="imageShop" src="https://res.cloudinary.com/crunchbase-production/image/upload/c_lpad,f_auto,q_auto:eco,dpr_1/itxiuybmyrbkkhrykvzi">
                            </a>
                        @endif
                        @if($itemProduct->lazada != null)
                            <a href="{{ $itemProduct->lazada }}">
                                <img class="imageShop" src="https://laz-img-cdn.alicdn.com/images/ims-web/TB1Hs8GaMFY.1VjSZFnXXcFHXXa.png">
                            </a>
                        @endif
                        @if($itemProduct->bukalapak != null)
                            <a href="{{ $itemProduct->bukalapak }}">
                                <img class="imageShop" src="https://assets.bukalapak.com/sigil/bukalapak-logo-primary.svg">
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="tabs tabs-product mb-2">
                        <ul class="nav nav-tabs">
                            <li class="nav-item active"><a class="nav-link py-3 px-4" href="#productDescription" data-toggle="tab">Description</a></li>
                            <!-- <li class="nav-item"><a class="nav-link py-3 px-4" href="#productInfo" data-toggle="tab">Additional Information</a></li>
                            <li class="nav-item"><a class="nav-link py-3 px-4" href="#productReviews" data-toggle="tab">Reviews (2)</a></li> -->
                        </ul>
                        <div class="tab-content p-0">
                            <div class="tab-pane p-4 active" id="productDescription">
                                <?= $itemProduct->description ?>
                            </div>
                            <div class="tab-pane p-4" id="productInfo">
                                <table class="table m-0">
                                    <tbody>
                                        <tr>
                                            <th class="border-top-0">
                                                Size:
                                            </th>
                                            <td class="border-top-0">
                                                Unique
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Colors
                                            </th>
                                            <td>
                                                Red, Blue
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Material
                                            </th>
                                            <td>
                                                100% Leather
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane p-4" id="productReviews">
                                <ul class="comments">
                                    <li>
                                        <div class="comment">
                                            <div class="img-thumbnail border-0 p-0 d-none d-md-block">
                                                <img class="avatar" alt="" src="img/avatars/avatar-2.jpg">
                                            </div>
                                            <div class="comment-block">
                                                <div class="comment-arrow"></div>
                                                <span class="comment-by">
                                                    <strong>Jack Doe</strong>
                                                    <span class="float-right">
                                                        <div class="pb-0 clearfix">
                                                            <div title="Rated 3 out of 5" class="float-left">
                                                                <input type="text" class="d-none" value="3" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'primary', 'size':'xs'}">
                                                            </div>
                    
                                                            <div class="review-num">
                                                                <span class="count" itemprop="ratingCount">2</span> reviews
                                                            </div>
                                                        </div>
                                                    </span>
                                                </span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae, gravida pellentesque urna varius vitae.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="comment">
                                            <div class="img-thumbnail border-0 p-0 d-none d-md-block">
                                                <img class="avatar" alt="" src="img/avatars/avatar.jpg">
                                            </div>
                                            <div class="comment-block">
                                                <div class="comment-arrow"></div>
                                                <span class="comment-by">
                                                    <strong>John Doe</strong>
                                                    <span class="float-right">
                                                        <div class="pb-0 clearfix">
                                                            <div title="Rated 3 out of 5" class="float-left">
                                                                <input type="text" class="d-none" value="3" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'primary', 'size':'xs'}">
                                                            </div>
                    
                                                            <div class="review-num">
                                                                <span class="count" itemprop="ratingCount">2</span> reviews
                                                            </div>
                                                        </div>
                                                    </span>
                                                </span>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra odio, gravida urna varius vitae, gravida pellentesque urna varius vitae.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <hr class="solid my-5">
                                <h4>Add a review</h4>
                                <div class="row">
                                    <div class="col">
                    
                                        <form action="" id="submitReview" method="post">
                                            <div class="form-row">
                                                <div class="form-group col pb-2">
                                                    <label class="required font-weight-bold text-dark">Rating</label>
                                                    <input type="text" class="rating-loading" value="0" title="" data-plugin-star-rating data-plugin-options="{'color': 'primary', 'size':'xs'}">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-6">
                                                    <label class="required font-weight-bold text-dark">Name</label>
                                                    <input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" required>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label class="required font-weight-bold text-dark">Email Address</label>
                                                    <input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label class="required font-weight-bold text-dark">Review</label>
                                                    <textarea maxlength="5000" data-msg-required="Please enter your review." rows="8" class="form-control" name="review" id="review" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col mb-0">
                                                    <input type="submit" value="Post Review" class="btn btn-primary btn-modern" data-loading-text="Loading...">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col">
                    <hr class="solid my-5">

                    <h4 class="mb-3">Related <strong>Products</strong></h4>
                    <div class="masonry-loader masonry-loader-showing">
                        <div class="row products product-thumb-info-list mt-3" data-plugin-masonry data-plugin-options="{'layoutMode': 'fitRows'}">
                            <div class="col-12 col-sm-6 col-lg-3 product">
                                <span class="product-thumb-info border-0">
                                    <a href="shop-cart.html" class="add-to-cart-product bg-color-primary">
                                        <span class="text-uppercase text-1">Add to Cart</span>
                                    </a>
                                    <a href="shop-product-sidebar-left.html">
                                        <span class="product-thumb-info-image">
                                            <img alt="" class="img-fluid" src="img/products/product-grey-1.jpg">
                                        </span>
                                    </a>
                                    <span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
                                        <a href="shop-product-sidebar-left.html">
                                            <h4 class="text-4 text-primary">Photo Camera</h4>
                                            <span class="price">
                                                <del><span class="amount">$325</span></del>
                                                <ins><span class="amount text-dark font-weight-semibold">$299</span></ins>
                                            </span>
                                        </a>
                                    </span>
                                </span>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3 product">
                                <span class="product-thumb-info border-0">
                                    <a href="shop-cart.html" class="add-to-cart-product bg-color-primary">
                                        <span class="text-uppercase text-1">Add to Cart</span>
                                    </a>
                                    <a href="shop-product-sidebar-left.html">
                                        <span class="product-thumb-info-image">
                                            <img alt="" class="img-fluid" src="img/products/product-grey-2.jpg">
                                        </span>
                                    </a>
                                    <span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
                                        <a href="shop-product-sidebar-left.html">
                                            <h4 class="text-4 text-primary">Golf Bag</h4>
                                            <span class="price">
                                                <span class="amount text-dark font-weight-semibold">$72</span>
                                            </span>
                                        </a>
                                    </span>
                                </span>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3 product">
                                <span class="product-thumb-info border-0">
                                    <a href="shop-cart.html" class="add-to-cart-product bg-color-primary">
                                        <span class="text-uppercase text-1">Add to Cart</span>
                                    </a>
                                    <a href="shop-product-sidebar-left.html">
                                        <span class="product-thumb-info-image">
                                            <img alt="" class="img-fluid" src="img/products/product-grey-3.jpg">
                                        </span>
                                    </a>
                                    <span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
                                        <a href="shop-product-sidebar-left.html">
                                            <h4 class="text-4 text-primary">Workout</h4>
                                            <span class="price">
                                                <span class="amount text-dark font-weight-semibold">$60</span>
                                            </span>
                                        </a>
                                    </span>
                                </span>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3 product">
                                <span class="product-thumb-info border-0">
                                    <a href="shop-cart.html" class="add-to-cart-product bg-color-primary">
                                        <span class="text-uppercase text-1">Add to Cart</span>
                                    </a>
                                    <a href="shop-product-sidebar-left.html">
                                        <span class="product-thumb-info-image">
                                            <img alt="" class="img-fluid" src="img/products/product-grey-4.jpg">
                                        </span>
                                    </a>
                                    <span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
                                        <a href="shop-product-sidebar-left.html">
                                            <h4 class="text-4 text-primary">Luxury bag</h4>
                                            <span class="price">
                                                <span class="amount text-dark font-weight-semibold">$199</span>
                                            </span>
                                        </a>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div> -->
        </div>

    </div>
</div>
@endsection
