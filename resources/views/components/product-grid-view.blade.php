<?php if(!isset($classes)){$classes='col-lg-3 col-md-3 col-sm-4 col-4';}?>

@php
    $typeid = $product->slug;
    $currency_icon = setting('CURRENCY_ICON') ? setting('CURRENCY_ICON') : '৳';
    
    // Rating calculation
    if ($product->reviews && $product->reviews->count() > 0) {
        $average_rating = $product->reviews->sum('rating') / $product->reviews->count();
        $review_count = $product->reviews->count();
    } else {
        $average_rating = 0;
        $review_count = 0;
    }

    // Wishlist check
    $isWishlisted = false;
    if (auth()->check()) {
        $isWishlisted = App\Models\wishlist::where('product_id', $product->id)->where('user_id', auth()->id())->exists();
    }

    // Discount calculation
    $hasDiscount = false;
    $discountLabel = '';
    $finalPrice = $product->price ?? $product->discount_price;
    
    if (($product->discount_price > 0 || $product->price) && $product->regular_price > $finalPrice) {
        $hasDiscount = true;
        if ($product->dis_type == '2') {
            $discountLabel = round((($product->regular_price - $finalPrice) / $product->regular_price) * 100) . '% OFF';
        } else {
            $discountLabel = $currency_icon . ($product->regular_price - $finalPrice) . ' OFF';
        }
    }
@endphp

<div class="product {{ $classes }} pxc">
    <div class="modern-product-card">
        <!-- Thumbnail & Badges Container -->
        <div class="product-thumb-wrapper">
            <!-- Discount Badge -->
            @if($hasDiscount)
                <span class="product-badge discount-badge">{{ $discountLabel }}</span>
            @endif

            <!-- Extra Msg / Promo Badge -->
            @if($product->prdct_extra_msg)
                <span class="product-badge promo-badge">{{ $product->prdct_extra_msg }}</span>
            @endif

            <!-- Wishlist Floating Button -->
            <form action="{{route('wishlist.add')}}" method="post" id="submit_payment_form{{$typeid}}" class="wishlist-form">
                @csrf
                <input type="hidden" name="product_id" value="{{$product->slug}}"> 
                <button type="submit" class="btn-wishlist {{ $isWishlisted ? 'active' : '' }}" title="Add to Wishlist">
                    <i class="{{ $isWishlisted ? 'fas fa-heart text-danger' : 'fal fa-heart' }}"></i>
                </button>
            </form>

            <!-- Product Image -->
            <a href="{{route('product.details', $product->slug)}}" class="product-img-link">
                <img src="{{ asset('uploads/product/'.$product->image) }}" alt="{{ $product->title }}" class="product-img" loading="lazy">
            </a>

            <!-- Quick View Hover Button -->
            <a href="{{route('product.details', $product->slug)}}" class="btn-quick-view">
                <i class="fal fa-eye mr-1"></i> Quick View
            </a>
        </div>

        <!-- Details Container -->
        <div class="product-info-wrapper">
            <!-- Ratings -->
            <div class="product-rating">
                <div class="stars">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($average_rating >= $i)
                            <i class="fas fa-star text-warning"></i>
                        @elseif ($average_rating >= $i - 0.5)
                            <i class="fas fa-star-half-alt text-warning"></i>
                        @else
                            <i class="far fa-star text-muted"></i>
                        @endif
                    @endfor
                </div>
                @if($review_count > 0)
                    <span class="rating-count">({{ $review_count }})</span>
                @endif
            </div>

            <!-- Product Title -->
            <h3 class="product-title">
                <a href="{{route('product.details', $product->slug)}}" title="{{ $product->title }}">
                    {{ $product->title }}
                </a>
            </h3>

            <!-- Price Display -->
            <div class="product-price-wrapper">
                @if($hasDiscount)
                    <span class="current-price">{{ $currency_icon }}{{ $finalPrice }}</span>
                    <span class="regular-price"><del>{{ $currency_icon }}{{ $product->regular_price }}</del></span>
                @else
                    <span class="current-price">{{ $currency_icon }}{{ $product->regular_price }}</span>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="product-actions">
                @if($product->quantity <= '0')
                    <a href="{{route('product.details', $product->slug)}}" class="btn-action-primary btn-preorder">
                        <i class="fal fa-clock mr-1"></i> Pre Order
                    </a>
                @else
                    @if($product->sheba != 1)
                        <button type="button" class="btn-action-primary productInfo" data-url="{{route('product.info', $product->slug)}}" id="productInfo" title="Buy Now">
                            <i class="fal fa-bolt mr-1"></i> Buy Now
                        </button>
                        <button type="button" class="btn-action-secondary productInfo" data-url="{{route('product.info', $product->slug)}}" id="productInfo" title="Add to Cart">
                            <i class="fal fa-shopping-bag"></i>
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

@once
@push('css')
<style>
    /* Modern Product Card Styling */
    .pxc {
        padding: 6px;
    }
    .modern-product-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    .modern-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
        border-color: #cbd5e1;
    }

    /* Thumbnail Area */
    .product-thumb-wrapper {
        position: relative;
        width: 100%;
        padding-top: 100%; /* 1:1 Aspect Ratio */
        background-color: #f8fafc;
        overflow: hidden;
    }
    .product-img-link {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .modern-product-card:hover .product-img {
        transform: scale(1.06);
    }

    /* Badges */
    .product-badge {
        position: absolute;
        z-index: 2;
        padding: 4px 9px;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .discount-badge {
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #ffffff;
    }
    .promo-badge {
        bottom: 10px;
        left: 10px;
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        backdrop-filter: blur(4px);
        max-width: 80%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Wishlist Button */
    .wishlist-form {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 3;
    }
    .btn-wishlist {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.06);
        padding: 0;
    }
    .btn-wishlist:hover {
        background: #fee2e2;
        color: #ef4444;
        border-color: #fca5a5;
        transform: scale(1.1);
    }
    .btn-wishlist.active {
        color: #ef4444;
    }

    /* Quick View */
    .btn-quick-view {
        position: absolute;
        bottom: -40px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.95);
        color: #1e293b;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 20px;
        backdrop-filter: blur(4px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.12);
        transition: all 0.3s ease;
        opacity: 0;
        white-space: nowrap;
        text-decoration: none;
        z-index: 2;
    }
    .btn-quick-view:hover {
        background: #1e293b;
        color: #ffffff;
    }
    .modern-product-card:hover .btn-quick-view {
        bottom: 12px;
        opacity: 1;
    }

    /* Product Info */
    .product-info-wrapper {
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        background: #ffffff;
    }
    .product-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 4px;
        font-size: 0.75rem;
    }
    .rating-count {
        color: #94a3b8;
        font-size: 0.72rem;
    }
    .product-title {
        margin: 0 0 6px 0;
        font-size: 0.9rem;
        font-weight: 600;
        line-height: 1.35;
        height: 2.7rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .product-title a {
        color: #1e293b;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .product-title a:hover {
        color: #3b82f6;
    }

    /* Pricing */
    .product-price-wrapper {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-bottom: 10px;
    }
    .current-price {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
    }
    .regular-price {
        font-size: 0.82rem;
        color: #94a3b8;
    }

    /* Action Buttons */
    .product-actions {
        display: flex;
        gap: 6px;
        margin-top: auto;
    }
    .btn-action-primary {
        flex: 1;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff !important;
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.82rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-action-primary:hover {
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
        transform: translateY(-1px);
        color: #ffffff;
    }
    .btn-action-secondary {
        width: 36px;
        height: 36px;
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0;
    }
    .btn-action-secondary:hover {
        background: #e2e8f0;
        color: #0f172a;
        transform: translateY(-1px);
    }
    .btn-preorder {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
</style>
@endpush

@push('js')
<script>
    // Wishlist form submission
    $(document).on('submit', '.wishlist-form', function(e) {
        e.preventDefault();
        let action = $(this).attr('action');
        let formData = $(this).serialize();
        let btn = $(this).find('.btn-wishlist');

        $.ajax({
            type: 'POST',
            url: action,
            data: formData,
            dataType: "JSON",
            beforeSend: function() {
                if (typeof loader === 'function') loader(true);
            },
            success: function (response) {
                btn.toggleClass('active');
                if (btn.hasClass('active')) {
                    btn.find('i').removeClass('fal far text-muted').addClass('fas text-danger');
                } else {
                    btn.find('i').removeClass('fas text-danger').addClass('fal');
                }
                if (typeof responseMessage === 'function') {
                    responseMessage(response.alert, response.message, response.alert.toLowerCase());
                }
            },
            complete: function() {
                if (typeof loader === 'function') loader(false);
            },
            error: function (xhr) {
                if (xhr.status == 422) {
                    if (typeof(xhr.responseJSON.errors) !== 'undefined') {
                        $.each(xhr.responseJSON.errors, function (key, error) { 
                            $('small.'+key+'').text(error);
                            $('#'+key+'').addClass('is-invalid');
                        });
                    }
                } else if (xhr.status == 401) {
                    alert('Please login first');
                    window.location = '/login';
                }
            }
        });
    });
</script>
@endpush
@endonce