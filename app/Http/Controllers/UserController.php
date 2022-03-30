<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getRole(Request $request): string
    {
        $role = $request->user()->role;

        if ($role == 0){
            return "user";
        } else {
            return "admin";
        }
    }

    public function getCart(Request $request){
        return $request->user()->cart;
    }

    public function getUser(Request $request){
        return $request->user();
    }




}
