@extends('layouts.front')
@section('page_title','Transaction Policy')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('Transaction Policy'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@section('body_content')
    @include('components.breadcrumb',['page_title_text'=>'Transaction Policy','paths'=>[
            0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
            1=>['name'=>'Transaction Policy','route'=>''],
        ]])
    <!-- START MAIN CONTENT -->
    <div class="main_content">
        <!-- STAT SECTION FAQ -->
        <div class="section small_pt">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="term_conditions">
                            <h3>Transaction Policy</h3><br/>
                            <h5 class="small_pt">PAYMENTS</h5>
                            <p class="mt-n2">You can currently purchase goods in LKR, although delivery is limited within Sri Lanka we do
                                accept worldwide payments through Global Visa, MasterCard and American Express.</p>
                            <div class="pl-2">
                                <h6>Payment Procedure</h6>
                                <ul>
                                    <li>For first-time Product/Item purchases:<br/>Select Products > Click “Add to Basket” > Click “Continue to Payment” > Review Order >
                                        Register with delivery details > Click “Check Out” > Select Payment Method (Credit/Debit Card) >
                                        Submit Card Details > Click “Proceed to Payment”.</li>

                                    <li>For continuous Product/Item purchases:<br/>Select Products > Click “Add to Basket” > Click “Continue to Payment” > Review Order >
                                        Confirm/Edit delivery details > Click “Check Out” > Select Payment Method (Credit/Debit Card) >
                                        Submit Card Details > Click “Proceed to Payment”</li>
                                    <li>For Service Bookings:<br/>Select a Service > Click “Book Now” > Select Reservation Slot > Fill Booking Form > Click “Pay
                                        Now” > Select Payment Method (Credit/Debit Card) > Submit Card Details > Click “Proceed to
                                        Payment”</li>
                                </ul>
                                <h6 class="mt-4">Payment Terms</h6>
                                <p class="mt-n3">By placing an order with us, you are</p>
                                <ol class="ml-3">
                                    <li>offering to purchase a product</li>
                                    <li>representing that you are of a legal age to form a binding contract</li>
                                    <li>representing all information you provide to us in connection with such order is true and accurate</li>
                                    <li>the authorized user of the payment method provided.</li>
                                </ol>
                                <p>The receipt by you of an order confirmation does not constitute our acceptance of an order. We
                                    retain the right to refuse any order request made by you at any given moment.</p>
                                <p>Prior to our acceptance of an order, verification of information may be required. We reserve the
                                    right at any time after receipt of your order to accept, modify or decline your order, or any potion
                                    thereof, even after your receipt of an order confirmation from us, for any reason whatsoever, and
                                    you will be duly notified of the same.</p>

                                <p>We reserve the right to limit the number of items ordered and to refuse service to you without
                                    prior notification, where the need so arises. In the event that an incorrect price, either due to
                                    typographical or other error, we shall have the right to refuse or cancel any such order placed for
                                    the incorrect price, regardless of whether the order is being or has been processed.</p>
                                <p>If payment has already been made or if your account has already been charged for the purchase
                                    and the order is cancelled, we will credit your Surya Shri Member account in Surya Shri Tokens
                                    equal and exact to the amount already being charged within 24 business hours.</p>

                                <small><strong>Applicable Payment Methods</strong></small>
                                <div class="ml-3">
                                    <p>Credit Card / Debit Card<br/>
                                        Master Cards / Visa<br/>
                                        American Express Card</p>
                                </div>
                                <p class="mt-n3">Where an order has been placed, the payment method cannot be changed</p>

                                <small class="mt-2"><strong>Status of Card Details submitted with Surya Shri</strong></small>
                                <p class="mt-n1">Your card details will be protected using the __________ used by our authorized payment
                                    gateway partner/s.</p>
                                <p class="mt-n2">We do not retain your credit / debit card information; it is submitted directly to our authorized
                                    payment gateway partner/s for payment processing.</p>
                                <p class="mt-n2">You can be assured that every credit/debit card transaction on SuryaShri.lk occurs within a
                                    secure environment.</p>
                                <p class="mt-n2">Furthermore, your card details will be protected using the PCI DSS Compliance (The Payment
                                    Card Industry Data Security Standard) used by our payment gateway partners.</p>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION FAQ -->
    </div>
@endsection
