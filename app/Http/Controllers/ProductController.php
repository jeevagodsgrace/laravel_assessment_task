<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class ProductController extends Controller
{
    public function list(Request $request) {
        $products = Product::all();
        return view('products.index',['products'=>$products]);
    }   

    public function productCheckout(Request $request, $id) {
        $product = Product::findOrFail($id);
        return view('products.checkout',['product'=>$product]);
    }

    public function makePayment(Request $request) {
        $validated = $request->validate([
            'pm_id' => 'required',
            'product_id' =>'required'
        ]);

        $product = Product::findOrFail($request->product_id);

        try {
            $stripeCharge = (new User)->charge(
                $product->price*100, $request->pm_id,['off_session'=>true]
            );
            // Using redirect instead of view. Purpose: Avoid refresh page issues.
            return redirect('/thankyou');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
