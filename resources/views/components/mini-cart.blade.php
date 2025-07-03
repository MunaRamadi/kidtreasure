{{-- resources/views/components/mini-cart.blade.php --}}

<div class="mini-cart-wrapper">
    <!-- أيقونة السلة -->
    <div class="cart-icon-container" data-bs-toggle="offcanvas" data-bs-target="#miniCartOffcanvas">
        <button class="cart-icon-btn">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-badge" id="cart-items-count">0</span>
        </button>
    </div>

    <!-- Mini Cart Offcanvas -->
    <div class="offcanvas offcanvas-end mini-cart-offcanvas" tabindex="-1" id="miniCartOffcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <i class="fas fa-shopping-basket me-2 text-primary"></i>
                سلة التسوق
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        
        <div class="offcanvas-body p-0">
            <!-- Loading State -->
            <div class="mini-cart-loading text-center py-5" id="mini-cart-loading">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">جاري التحميل...</span>
                </div>
                <p class="mt-2 text-muted">جاري تحميل السلة...</p>
            </div>

            <!-- Empty State -->
            <div class="mini-cart-empty text-center py-5 d-none" id="mini-cart-empty">
                <div class="empty-cart-icon mb-3">
                    <i class="fas fa-shopping-cart fa-3x text-muted"></i>
                </div>
                <h6 class="text-muted">سلة التسوق فارغة</h6>
                <p class="small text-muted mb-3">لم تقم بإضافة أي منتجات بعد</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
                    تصفح المنتجات
                </a>
            </div>

            <!-- Cart Items -->
            <div class="mini-cart-items d-none" id="mini-cart-items">
                <div class="cart-items-list p-3" id="cart-items-container">
                    <!-- سيتم ملء هذا القسم ديناميكياً -->
                </div>
                
                <!-- Cart Summary -->
                <div class="mini-cart-footer">
                    <div class="cart-total-section p-3 bg-light border-top">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">الإجمالي:</span>
                            <span class="fw-bold text-primary fs-5" id="mini-cart-total">0.00 د.أ</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-3">
                            <span>عدد المنتجات:</span>
                            <span id="mini-cart-count">0 قطعة</span>
                        </div>
                        
                        <div class="cart-actions">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-primary w-100 mb-2">
                                <i class="fas fa-eye me-2"></i>
                                عرض السلة
                            </a>
                            <button class="btn btn-primary w-100" onclick="proceedToCheckout()">
                                <i class="fas fa-credit-card me-2"></i>
                                إتمام الشراء
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Mini Cart Styles */
.mini-cart-wrapper {
    position: relative;
}

.cart-icon-container {
    position: relative;
}

.cart-icon-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    cursor: pointer;
}

.cart-icon-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4c93 100%);
}

.cart-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: bold;
    border: 2px solid white;
    animation: pulse 2s infinite;
}

/* استكمال CSS للـ Mini Cart */

.mini-cart-offcanvas {
    width: 400px !important;
    box-shadow: -5px 0 25px rgba(0, 0, 0, 0.1);
}

.mini-cart-offcanvas .offcanvas-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
}

.mini-cart-offcanvas .offcanvas-title {
    font-weight: 600;
    font-size: 1.1rem;
}

.mini-cart-offcanvas .btn-close {
    filter: invert(1);
    opacity: 0.8;
}

.mini-cart-offcanvas .btn-close:hover {
    opacity: 1;
}

/* Cart Items Styles */
.cart-item {
    background: white;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 12px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.cart-item:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transform: translateY(-1px);
}

.cart-item-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #dee2e6;
}

.cart-item-details {
    flex: 1;
    margin-right: 12px;
}

.cart-item-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: #2c3e50;
    margin-bottom: 4px;
    line-height: 1.3;
}

.cart-item-price {
    color: #667eea;
    font-weight: 600;
    font-size: 0.95rem;
}

.cart-item-quantity {
    display: flex;
    align-items: center;
    margin-top: 8px;
}

.quantity-btn {
    width: 28px;
    height: 28px;
    border: 1px solid #dee2e6;
    background: white;
    color: #6c757d;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.quantity-btn:hover {
    background: #f8f9fa;
    border-color: #667eea;
    color: #667eea;
}

.quantity-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.quantity-input {
    width: 40px;
    height: 28px;
    text-align: center;
    border: 1px solid #dee2e6;
    border-left: none;
    border-right: none;
    background: #f8f9fa;
    font-size: 0.85rem;
    font-weight: 600;
}

.cart-item-remove {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 1rem;
    cursor: pointer;
    padding: 5px;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.cart-item-remove:hover {
    background: #dc3545;
    color: white;
}

/* Loading Animation */
.mini-cart-loading .spinner-border {
    width: 2.5rem;
    height: 2.5rem;
}

/* Empty State */
.empty-cart-icon i {
    opacity: 0.3;
}

/* Cart Footer */
.mini-cart-footer {
    position: sticky;
    bottom: 0;
    background: white;
    border-top: 1px solid #dee2e6;
}

.cart-total-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
}

/* Responsive */
@media (max-width: 576px) {
    .mini-cart-offcanvas {
        width: 100% !important;
    }
    
    .cart-item {
        padding: 12px;
    }
    
    .cart-item-image {
        width: 50px;
        height: 50px;
    }
}

/* Animation for cart badge update */
.cart-badge.updated {
    animation: bounce 0.6s ease;
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0) scale(1);
    }
    40%, 43% {
        transform: translate3d(0,-8px,0) scale(1.1);
    }
    70% {
        transform: translate3d(0,-4px,0) scale(1.05);
    }
    90% {
        transform: translate3d(0,-1px,0) scale(1.02);
    }
}

/* Custom Scrollbar for cart items */
.cart-items-list {
    max-height: 400px;
    overflow-y: auto;
}

.cart-items-list::-webkit-scrollbar {
    width: 6px;
}

.cart-items-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.cart-items-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.cart-items-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
<script>

class MiniCart {
    constructor() {
        this.init();
        this.bindEvents();
    }

    init() {
        // تحميل السلة عند بدء التشغيل
        this.loadCart();
        
        // تحديث عدد العناصر في البداية
        this.updateCartBadge();
    }

    bindEvents() {
        // فتح السلة
        document.addEventListener('click', (e) => {
            if (e.target.closest('.cart-icon-container')) {
                this.openMiniCart();
            }
        });

        // إغلاق السلة
        document.addEventListener('hidden.bs.offcanvas', (e) => {
            if (e.target.id === 'miniCartOffcanvas') {
                this.onCartClosed();
            }
        });
    }

    // تحميل محتويات السلة
    async loadCart() {
        try {
            this.showLoading();
            
            const response = await fetch('/api/cart/mini', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                throw new Error('فشل في تحميل السلة');
            }

            const data = await response.json();
            this.renderCart(data);
            
        } catch (error) {
            console.error('خطأ في تحميل السلة:', error);
            this.showError('حدث خطأ في تحميل السلة');
        }
    }

    // عرض حالة التحميل
    showLoading() {
        document.getElementById('mini-cart-loading').classList.remove('d-none');
        document.getElementById('mini-cart-empty').classList.add('d-none');
        document.getElementById('mini-cart-items').classList.add('d-none');
    }

    // عرض السلة
    renderCart(cartData) {
        const { items, total, count } = cartData;
        
        document.getElementById('mini-cart-loading').classList.add('d-none');
        
        if (!items || items.length === 0) {
            this.showEmptyCart();
            return;
        }

        this.showCartItems(items, total, count);
    }

    // عرض السلة الفارغة
    showEmptyCart() {
        document.getElementById('mini-cart-empty').classList.remove('d-none');
        document.getElementById('mini-cart-items').classList.add('d-none');
        this.updateCartBadge(0);
    }

    // عرض عناصر السلة
    showCartItems(items, total, count) {
        document.getElementById('mini-cart-empty').classList.add('d-none');
        document.getElementById('mini-cart-items').classList.remove('d-none');
        
        const container = document.getElementById('cart-items-container');
        container.innerHTML = '';
        
        items.forEach(item => {
            container.appendChild(this.createCartItemElement(item));
        });
        
        // تحديث الإجمالي والعدد
        document.getElementById('mini-cart-total').textContent = `${total.toFixed(2)} د.أ`;
        document.getElementById('mini-cart-count').textContent = `${count} قطعة`;
        
        this.updateCartBadge(count);
    }

    // إنشاء عنصر في السلة
    createCartItemElement(item) {
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.setAttribute('data-item-id', item.id);
        
        div.innerHTML = `
            <div class="d-flex align-items-center">
                <img src="${item.image || '/images/default-product.jpg'}" 
                     alt="${item.name}" 
                     class="cart-item-image">
                
                <div class="cart-item-details">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">${item.price.toFixed(2)} د.أ</div>
                    
                    <div class="cart-item-quantity">
                        <button class="quantity-btn minus-btn" data-action="decrease" data-item-id="${item.id}">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" 
                               class="quantity-input" 
                               value="${item.quantity}" 
                               min="1" 
                               data-item-id="${item.id}"
                               readonly>
                        <button class="quantity-btn plus-btn" data-action="increase" data-item-id="${item.id}">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                
                <button class="cart-item-remove" data-item-id="${item.id}" title="إزالة من السلة">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        
        // ربط الأحداث
        this.bindCartItemEvents(div);
        
        return div;
    }

    // ربط أحداث عناصر السلة
    bindCartItemEvents(element) {
        // أزرار الكمية
        element.querySelectorAll('.quantity-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const action = e.target.closest('.quantity-btn').dataset.action;
                const itemId = e.target.closest('.quantity-btn').dataset.itemId;
                this.updateQuantity(itemId, action);
            });
        });

        // زر الحذف
        element.querySelector('.cart-item-remove').addEventListener('click', (e) => {
            const itemId = e.target.closest('.cart-item-remove').dataset.itemId;
            this.removeItem(itemId);
        });
    }

    // تحديث الكمية
    async updateQuantity(itemId, action) {
        try {
            const response = await fetch(`/api/cart/update-quantity`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    item_id: itemId,
                    action: action
                })
            });

            if (!response.ok) {
                throw new Error('فشل في تحديث الكمية');
            }

            const data = await response.json();
            
            if (data.success) {
                this.loadCart(); // إعادة تحميل السلة
                this.showSuccessMessage(data.message || 'تم تحديث الكمية بنجاح');
            } else {
                this.showError(data.message || 'فشل في تحديث الكمية');
            }
            
        } catch (error) {
            console.error('خطأ في تحديث الكمية:', error);
            this.showError('حدث خطأ في تحديث الكمية');
        }
    }

    // إزالة عنصر من السلة
    async removeItem(itemId) {
        if (!confirm('هل أنت متأكد من إزالة هذا المنتج من السلة؟')) {
            return;
        }

        try {
            const response = await fetch(`/api/cart/remove/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                throw new Error('فشل في إزالة المنتج');
            }

            const data = await response.json();
            
            if (data.success) {
                this.loadCart(); // إعادة تحميل السلة
                this.showSuccessMessage(data.message || 'تم إزالة المنتج من السلة');
            } else {
                this.showError(data.message || 'فشل في إزالة المنتج');
            }
            
        } catch (error) {
            console.error('خطأ في إزالة المنتج:', error);
            this.showError('حدث خطأ في إزالة المنتج');
        }
    }

    // فتح السلة المصغرة
    openMiniCart() {
        this.loadCart(); // تحديث السلة عند فتحها
    }

    // عند إغلاق السلة
    onCartClosed() {
        // يمكن إضافة منطق إضافي هنا
    }

    // تحديث شارة السلة
    updateCartBadge(count = null) {
        const badge = document.getElementById('cart-items-count');
        
        if (count === null) {
            // الحصول على العدد من السيرفر
            fetch('/api/cart/count', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                badge.textContent = data.count || 0;
                badge.classList.add('updated');
                setTimeout(() => badge.classList.remove('updated'), 600);
            })
            .catch(error => {
                console.error('خطأ في تحديث عدد السلة:', error);
            });
        } else {
            badge.textContent = count;
            badge.classList.add('updated');
            setTimeout(() => badge.classList.remove('updated'), 600);
        }
    }

    // عرض رسالة نجاح
    showSuccessMessage(message) {
        this.showToast(message, 'success');
    }

    // عرض رسالة خطأ
    showError(message) {
        this.showToast(message, 'error');
    }

    // عرض Toast notification
    showToast(message, type = 'info') {
        // إنشاء Toast element
        const toastId = 'toast-' + Date.now();
        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" 
                 role="alert" 
                 id="${toastId}"
                 data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;

        // إضافة Toast إلى الصفحة
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }

        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        
        // إظهار Toast
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement);
        toast.show();

        // حذف Toast بعد انتهاء العرض
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    }
}

// إتمام عملية الشراء
function proceedToCheckout() {
    window.location.href = '/checkout';
}

// تهيئة Mini Cart عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    window.miniCart = new MiniCart();
});

// إضافة منتج إلى السلة (يمكن استدعاؤها من صفحات أخرى)
window.addToCart = async function(productId, quantity = 1) {
    try {
        const response = await fetch('/api/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        });

        if (!response.ok) {
            throw new Error('فشل في إضافة المنتج إلى السلة');
        }

        const data = await response.json();
        
        if (data.success) {
            window.miniCart.updateCartBadge();
            window.miniCart.showSuccessMessage(data.message || 'تم إضافة المنتج إلى السلة');
            
            // فتح السلة المصغرة
            const offcanvas = new bootstrap.Offcanvas(document.getElementById('miniCartOffcanvas'));
            offcanvas.show();
        } else {
            window.miniCart.showError(data.message || 'فشل في إضافة المنتج إلى السلة');
        }
        
    } catch (error) {
        console.error('خطأ في إضافة المنتج:', error);
        window.miniCart.showError('حدث خطأ في إضافة المنتج إلى السلة');
    }
};
</script>