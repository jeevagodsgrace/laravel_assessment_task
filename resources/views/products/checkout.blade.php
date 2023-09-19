@extends('layouts.layout')

@section('headerScript')
   <script src="https://js.stripe.com/v3/"></script>
   <style>
      .full_height {
         height: 100vh;
      }
   </style>
@stop

@section('content')
   @if ($product->id)
      <div class="row col-12 pt-5 full_height">
            <div class="col-lg-8 col-md-10 col-sm-1" >
               <div class="mb-2 pl-1">                  
                     <h1>{{ $product->name }}</h1>
                     <p><b>Rs. {{ $product->price }}</b></p>
                     <p>{{ $product->description }}</p>
               </div>
            </div>
            <div class="col-lg-4 bg-light pt-3">
               <div class="alert alert-danger d-none" id='error_messge'></div>
 
               <!-- Stripe Elements Placeholder -->
               <div id="card-element" class="mb-2 mt-2"></div>
                
               <button id="card-button" class="btn btn-primary mt-3">
                  <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status" aria-hidden="true"></span>
                  Process Payment
               </button>
               <a href="{{ asset('/') }}" class="btn btn-primary mt-3 ml-1">Cancel</a>
               <form method="POST" action="{{ asset('/makePayment') }}" id="paymentForm">
                  @csrf
                  <input type="hidden" name="pm_id" value="" id="paymentid" />
                  <input type="hidden" name="product_id" value="{{ $product->id }}" />
               </form>
            </div>
      </div>
   @endif
@stop

@section('bodyScript')
<script>
   const stripe = Stripe("{{ env('STRIPE_KEY') }}");
 
   const elements = stripe.elements();
   const cardElement = elements.create('card', 
         {hidePostalCode: true});
 
   cardElement.mount('#card-element');

   const cardHolderName = "Developer";
   const cardButton = document.getElementById('card-button');
   const errorMessage = document.getElementById('error_messge');
   const spinner = document.getElementById('spinner');
    
   cardButton.addEventListener('click', async (e) => {
      errorMessage.classList.add('d-none');
      spinner.classList.remove('d-none');
       const { paymentMethod, error } = await stripe.createPaymentMethod(
           'card', cardElement, {
               billing_details: { name: cardHolderName }
           }
       );
    
       if (error) {
         errorMessage.classList.remove('d-none');
         errorMessage.innerHTML = error.message;
         spinner.classList.add('d-none');
       } else {
         doPayment(paymentMethod.id);
       }
   });

   function doPayment(paymentId) {
      const paymentidElem = document.getElementById('paymentid');
      paymentidElem.value = paymentId;
      document.getElementById("paymentForm").submit();
   }
</script>
@stop