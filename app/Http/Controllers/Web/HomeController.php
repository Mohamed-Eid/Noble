<?php

namespace App\Http\Controllers\web;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class HomeController extends Controller
{
    public function index()
    {        
        // $categories = Category::with(['products' => function ($q){
        //     $q->orderBy('orders', 'desc');
        // }])->has('products')->get();

        $categories =Category::all();
        $products = Product::has('images')->has('sizes')->latest()->take(10)->get();

        return view('web.index',compact('products','categories'));
    }
}
