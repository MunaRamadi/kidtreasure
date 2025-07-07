@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow p-4">
                <h2 class="mb-4 text-center">الدفع بالبطاقة الائتمانية</h2>
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- البطاقات المحفوظة -->
                @if(auth()->user()->stripe_payment_method_id)
                <div class="mb-4">
                    <h5>البطاقات المحفوظة</h5>
                    <div class="card bg-light p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-credit-card text-primary"></i>
                                <span class="ms-2">•••• •••• •••• •••• (محفوظة)</span>
                            </div>
                            <button class="btn btn-success btn-sm" onclick="payWithSavedCard()">
                                استخدم هذه البطاقة
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                <!-- إضافة بطاقة جديدة -->
                <div class="mb-3">
                    <h5>إضافة بطاقة جديدة</h5>
                </div>

                <form id="stripe-form" action="{{ route('checkout.stripe') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="card-element" class="form-label">معلومات البطاقة</label>
                        <div id="card-element" class="form-control"></div>
                        <div id="card-errors" class="text-danger mt-2"></div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" id="save-card" class="form-check-input">
                        <label class="form-check-label" for="save-card">
                            حفظ هذه البطاقة للدفع المستقبلي
                        </label>
                    </div>

                    <button id="pay-btn" class="btn btn-primary w-100 mt-3" type="submit">
                        ادفع الآن ({{ number_format($orderData['total'], 2) }} USD)
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var stripe = Stripe("{{ config('services.stripe.key') }}");
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('stripe-form');
        var payBtn = document.getElementById('pay-btn');
        var cardErrors = document.getElementById('card-errors');
        var saveCardCheckbox = document.getElementById('save-card');

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            payBtn.disabled = true;

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    cardErrors.textContent = result.error.message;
                    payBtn.disabled = false;
                } else {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);

                    // إذا تم اختيار حفظ البطاقة
                    if (saveCardCheckbox.checked) {
                        saveCard(result.token.id);
                    } else {
                        form.submit();
                    }
                }
            });
        });
    });

    function saveCard(token) {
        fetch('{{ route("checkout.save-card") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                stripeToken: token
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // بعد حفظ البطاقة، أكمل عملية الدفع
                document.getElementById('stripe-form').submit();
            } else {
                alert('فشل في حفظ البطاقة: ' + data.message);
                document.getElementById('pay-btn').disabled = false;
            }
        })
        .catch(error => {
            alert('خطأ في حفظ البطاقة');
            document.getElementById('pay-btn').disabled = false;
        });
    }

    function payWithSavedCard() {
        if (confirm('هل تريد استخدام البطاقة المحفوظة؟')) {
            fetch('{{ route("checkout.pay-with-saved-card") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    payment_method_id: '{{ auth()->user()->stripe_payment_method_id ?? "" }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect_url;
                } else {
                    alert('فشل في الدفع: ' + data.message);
                }
            })
            .catch(error => {
                alert('خطأ في عملية الدفع');
            });
        }
    }
</script>
@endsection
