{{--
  File: resources/views/pages/cart/partials/cart-content.blade.php
  Description: Renders the cart table and summary when the cart is not empty.
--}}
<div class="row">
    <div class="col-lg-8">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10%;">الصورة</th>
                        <th scope="col" style="width: 35%;">المنتج</th>
                        <th scope="col" style="width: 15%;">السعر</th>
                        <th scope="col" style="width: 20%;">الكمية</th>
                        <th scope="col" style="width: 15%;">الإجمالي</th>
                        <th scope="col" style="width: 5%;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->items as $item)
                        @if($item->product) {{-- التأكد من أن المنتج لا يزال موجودًا --}}
                        <tr id="cart-item-row-{{ $item->product_id }}" data-product-id="{{ $item->product_id }}">
                            <td>
                                <a href="{{ route('products.show', $item->product) }}">
                                    <img src="{{ $item->current_product_image }}" alt="{{ $item->current_product_name }}" class="img-fluid rounded cart-item-image">
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('products.show', $item->product) }}" class="text-dark text-decoration-none">{{ $item->current_product_name }}</a>
                                <div class="small text-muted">المخزون: {{ $item->product->stock_quantity }}</div>
                            </td>
                            <td>{{ number_format($item->price, 2) }} دينار</td>
                            <td>
                                <div class="quantity-input-wrapper" data-product-id="{{ $item->product_id }}">
                                    <span class="quantity-btn minus-btn">-</span>
                                    <input type="number"
                                           class="form-control quantity-input"
                                           value="{{ $item->quantity }}"
                                           min="0"
                                           max="{{ $item->product->stock_quantity }}"
                                           data-product-id="{{ $item->product_id }}"
                                           data-update-url="{{ route('cart.update', $item->product_id) }}">
                                    <span class="quantity-btn plus-btn">+</span>
                                </div>
                                <div id="spinner-{{ $item->product_id }}" class="spinner mt-1"></div>
                            </td>
                            <td id="item-subtotal-{{ $item->product_id }}">{{ number_format($item->total, 2) }} دينار</td>
                            <td>
                                <a href="#"
                                   class="remove-item-btn"
                                   data-delete-url="{{ route('cart.remove', $item->product_id) }}"
                                   title="حذف المنتج">
                                   <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="#" id="clear-cart-btn" data-url="{{ route('cart.clear') }}" class="btn btn-outline-danger mt-3">تفريغ السلة</a>
    </div>

    <div class="col-lg-4">
        <div class="cart-summary">
            <h4 class="mb-4">ملخص السلة</h4>
            <div class="d-flex justify-content-between mb-2">
                <span>عدد المنتجات</span>
                <span id="cart-total-items">{{ $cart->total_items }}</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5">
                <span>الإجمالي الكلي</span>
                <span id="cart-total-price">{{ number_format($cart->total_price, 2) }} دينار</span>
            </div>
            <p class="text-muted small mt-2">الشحن والضرائب ستحسب عند الدفع.</p>
            <div class="d-grid mt-4">
                <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg">المتابعة لإتمام الشراء</a>
            </div>
        </div>
    </div>
</div>