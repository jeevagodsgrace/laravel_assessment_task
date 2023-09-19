@extends('layouts.layout')

@section('content')
   @if ($products->count())
      <h1 class="pt-5 text-center">Products</h1>
      <div class="row col-12 pt-3">
         @foreach ($products as $product)
            <div class="col-lg-3 col-md-6 col-sm-1" >
               <div class="card  mb-2 pl-1">
                  <div class="card-body text-center"> 
                     <p>{{ $product->name }}</p>
                     <p><b>Rs. {{ $product->price }}</b></p>
                     <a class="btn btn-primary text-white" href="{{ asset('product_checkout/'.$product->id) }}">Buy now</a>
                  </div>
               </div>
            </div>
         @endforeach
      </div>
   @endif
@stop