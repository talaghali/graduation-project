@extends('website.layouts.app')

@section('title', 'Donate - Voices Of Gaza')

@section('content')
    <!-- section بداية  -->
    <section class="donate-large position-relative" data-aos="fade-up" data-aos-duration="1000">
        <div class="container-fluid p-0">
            <div
                class="donate-img d-flex justify-content-center align-items-center text-center text-white position-relative">

                <!-- النص فوق الصورة -->
                <div class="text-content position-relative z-2">
                    <p class="main-headings" style="max-width: 924px;">Contribute to supporting families </p>
                    <p class="main-headings" style="max-width: 924px;">and displaced
                        people in Gaza</p>
                </div>

                <!-- الطبقة الداكنة -->
                <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

            </div>
        </div>
    </section>
    <!-- pay section  -->
    <section class="form mt-5" data-aos="fade-up" data-aos-duration="2000">
        <div class="container-fluid">
            <div class="form-border donate-center  p-5">
                <form id="donationForm" method="POST">
                    @csrf
                    <input type="hidden" id="payment_method" name="payment_method" value="">
                    <input type="hidden" id="selected_amount" name="amount" value="">

                    <div class="row p-2">
                        <div class="col-6">
                            <p class="form-label">Amount</p>
                            <div class="row justify-content-start g-3">
                                <div class="col-auto">
                                    <a class="price-style text-decoration-none amount-btn" data-amount="50">$50</a>
                                </div>
                                <div class="col-auto">
                                    <a class="price-style text-decoration-none amount-btn" data-amount="70">$70</a>
                                </div>
                                <div class="col-auto">
                                    <a class="price-style text-decoration-none amount-btn" data-amount="100">$100</a>
                                </div>
                            </div>
                            <div class="row justify-content-start g-3 align-items-center mt-3">
                                <div class="col-auto">
                                    <a class="price-style m-0 text-decoration-none amount-btn" data-amount="200">$200</a>
                                </div>
                                <div class="col-auto">
                                    <input type="number" id="custom_amount" class="form-control other-h" placeholder="$ other" min="1" step="0.01">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <p class="form-label">Select Story</p>
                            <select id="story_reference" name="story_reference" class="form-select form-select-lg mb-3">
                                <option value="">General Donation</option>
                                <option value="A Bowl of Hope in the Ruins">A Bowl of Hope in the Ruins</option>
                                <option value="Hind Rajab and her family">Hind Rajab and her family</option>
                                <option value="Mohammed Bahar">Mohammed Bahar</option>
                                <option value="A Night Under Bombing">A Night Under Bombing</option>
                                <option value="The Last Call">The Last Call</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-6">
                            <label class="form-label">Name *</label>
                            <input type="text" id="donor_name" name="donor_name" class="form-control form-control-w" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Email *</label>
                            <input type="email" id="donor_email" name="donor_email" class="form-control form-control-w" required>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-6">
                            <label class="form-label">Payment Method</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <div class="d-flex gap-5 border rounded-3 px-lg-5 py-2">
                            <a href="#" class="pay-option" data-method="paypal" title="Pay with PayPal">
                                <i class="fa-brands fa-cc-paypal pay-icons paypal-color"></i>
                            </a>
                        </div>
                    </div>

                    <div class="donate-pay d-flex justify-content-center align-items-center mt-4">
                        <button type="submit" id="donateBtn" class="text-decoration-none text-white rounded-3 d-flex justify-content-center align-items-center border-0" disabled>
                            <i class="fa-solid fa-circle-dollar-to-slot pe-2" width="24px" height="24px"></i>
                            <span id="donate-btn-text">Select Payment Method</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let selectedAmount = 0;
        let selectedPaymentMethod = '';

        console.log('Donation form script loaded');

        // Amount selection
        document.querySelectorAll('.amount-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                selectedAmount = this.getAttribute('data-amount');
                document.getElementById('selected_amount').value = selectedAmount;
                document.getElementById('custom_amount').value = '';
                updateDonateButton();
            });
        });

        // Custom amount
        document.getElementById('custom_amount').addEventListener('input', function() {
            if (this.value) {
                document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));
                selectedAmount = this.value;
                document.getElementById('selected_amount').value = selectedAmount;
                updateDonateButton();
            }
        });

        // Payment method selection
        document.querySelectorAll('.pay-option').forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Payment method clicked:', this.getAttribute('data-method'));
                document.querySelectorAll('.pay-option').forEach(o => o.classList.remove('active'));
                this.classList.add('active');
                selectedPaymentMethod = this.getAttribute('data-method');
                document.getElementById('payment_method').value = selectedPaymentMethod;
                console.log('Payment method set to:', selectedPaymentMethod);
                updateDonateButton();
            });
        });

        // Update donate button
        function updateDonateButton() {
            const btn = document.getElementById('donateBtn');
            const btnText = document.getElementById('donate-btn-text');

            if (selectedAmount > 0 && selectedPaymentMethod) {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
                btnText.textContent = 'Donate with PayPal';
            } else {
                btn.disabled = true;
                btn.style.opacity = '0.6';
                btn.style.cursor = 'not-allowed';
                if (!selectedAmount) {
                    btnText.textContent = 'Select Amount';
                } else if (!selectedPaymentMethod) {
                    btnText.textContent = 'Select Payment Method';
                }
            }
        }

        // Form submission
        document.getElementById('donationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            console.log('Form submitted');
            console.log('Selected Amount:', selectedAmount);
            console.log('Selected Payment Method:', selectedPaymentMethod);

            // Validation
            if (!selectedAmount || selectedAmount <= 0) {
                alert('Please select or enter a donation amount');
                return;
            }

            const name = document.getElementById('donor_name').value;
            const email = document.getElementById('donor_email').value;

            if (!name || !email) {
                alert('Please fill in your name and email');
                return;
            }

            if (!selectedPaymentMethod) {
                alert('Please select a payment method');
                return;
            }

            // Set action for PayPal payment
            this.action = '{{ route("paypal.payment") }}';
            console.log('PayPal selected, action:', this.action);

            // Log form data before submission
            const formData = new FormData(this);
            console.log('Form Data:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ':', value);
            }

            // Submit form
            console.log('Submitting form...');
            this.submit();
        });
    </script>

    <style>
        .amount-btn.active, .pay-option.active {
            opacity: 1 !important;
            transform: scale(1.1);
            border: 2px solid #b70003;
            border-radius: 8px;
            padding: 5px;
        }
        .pay-option {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .pay-option:hover {
            transform: scale(1.05);
        }
        #donateBtn {
            transition: all 0.3s ease;
        }
    </style>
@endpush
