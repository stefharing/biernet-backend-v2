<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request){

        $request->validate([
            'total' => 'required',
            'adress' => 'required|max:255'
        ]);

        Order::create([
            'user_id' => $request->user()->id,
            'total' => $request['total'],
            'adress' => $request['adress']
        ]);

        return ('order created successfully');
    }

    public function addOrderItem(Request $request){

        $cart_items = $request['items'];

        $products = collect([]);

        $order = Order::where('user_id', 3)->first();

        foreach ($cart_items as $cart_item){
            $products->push($cart_item);
        }

        foreach ($products as $product){
            OrderItem::create(
                [
                    'order_id' => $order->id,
                    'product_id' => $product['id']
                ]);}


    }

    public function getAllOrders(){
        $orders = Order::all();

        $orders_coll = collect([]);

        foreach ($orders as $order){
            $user = User::find($order->user_id);

            $order = [
                "order" => $order,
                "user_details" => [
                    "customer_name" => $user->name,
                    "customer_email" => $user->email,
                ]
            ];

            $orders_coll->push($order);
        }

        return $orders_coll;

    }

    public function getUserOrders(Request $request){

        $orders = Order::where('user_id',$request->user()->id)->get();

        $data = [
            "orders" => $orders,
            "user_details" => [
                "customer_name" => $request->user()->name,
                "customer_email" => $request->user()->email,
            ]
        ];

        return $data;
    }


}
