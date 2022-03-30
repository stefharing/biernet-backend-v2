<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class CartController extends Controller
{
    public function createCart(Request $request)
    {
        $request->validate([
            'user_id' => 'required|max:255',
            'total' => 'required',
        ]);

        Cart::create($request->all());

        return ('cart created successfully');
    }

    public function addItem(Request $request, $id){

        $user_id = $request->user()->id;

        if (Cart::where('user_id', $user_id)->exists()) {
            $cart_id = $request->user()->cart->id;

            $cart_items = Cart::find($cart_id)->cartItems;

            $cart_item = $cart_items->where('product_id', $id)->first();

            if ($cart_item !== null) {
                $cart_item->quantity++;
                $cart_item->save();
            } else {
                CartItem::create(
                    [
                        'cart_id' => $cart_id,
                        'product_id' => $id,
                        'quantity' => 1
                    ]);
            }
        } else {
            $cart = Cart::create([
                        'user_id' => $user_id,
                        'total' => 10
                    ]);

            CartItem::create(
                [
                    'cart_id' => $cart->id,
                    'product_id' => $id,
                    'quantity' => 1
                ]);
        }

        return ("success");
    }

    public function removeItem(Request $request, $id){

        $cart_id = $request->user()->cart->id;

        $cart_items = Cart::find($cart_id)->cartItems;

        $cart_item_id = $cart_items->where('product_id', $id)->first();

        CartItem::find($cart_item_id)->first()->delete();
    }

    public function getItems(Request $request){

        $cart_id = $request->user()->cart->id;

        $cart_items = Cart::find($cart_id)->cartItems;

        if (sizeof($cart_items) != 0){
            return $cart_items;
        } else {
            return "No items in cart";
        }

    }

    public function getProducts(Request $request ){

        $cart_id = $request->user()->cart->id;

        $cart_items = Cart::find($cart_id)->cartItems;

        $products = collect([]);

        foreach ($cart_items as $cart_item){
            $products->push(Product::find($cart_item->product_id));
        }

        if (sizeof($products) != 0) {
            return $products;
        } else {
            return "No items in cart";
        }
    }

    public function getTotal(Request $request){

        $usercart = $request->user()->cart->first();

        $cartItems = CartItem::where('cart_id', $usercart->id)->get();

        $total = 0;

        foreach($cartItems as $cartItem){
            $qty = $cartItem->quantity;
            $product = Product::find($cartItem->product_id);
            $price = $product->price;

            $total_price = $qty*$price;

            $total = $total + $total_price;
        }

        return $total;
    }

    public function getQuantities(Request $request){
        $cart_id = $request->user()->cart->id;

        $cart_items = Cart::find($cart_id)->cartItems;

        $quantities = collect([]);

        foreach($cart_items as $cart_item){
            $quantities->push($cart_item->quantity);

        }

        return $quantities;
    }

    public function updateQuantity(Request $request){

        $cart_id = $request->user()->cart->id;

        $cart_items = Cart::find($cart_id)->cartItems;

        $cart_item = $cart_items->where('product_id', $request['product_id'])->first();

        $cart_item->quantity = $request['quantity'];
        $cart_item->save();



    }
}
