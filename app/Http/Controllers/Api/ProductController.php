<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailResource;
use App\Http\Resources\OneProductResource;
use App\Http\Resources\ProductResource;
use App\Product;

class ProductController extends Controller
{
    use ApiResponseTrait;
    
    public function test()
    {
        $products = Product::has('images')->has('sizes')->get();
        //return ($products);
        return $this->ApiResponse(true , [] , __('api.all_products') , ProductResource::collection($products) ,200);
    }
    
    public function get_all()
    { 
        $products = Product::has('images')->has('sizes')->get();

        return $this->ApiResponse(true , [] , __('api.all_products') , ProductResource::collection($products) ,200);
    }

    public function product_page()
    {

    }

    public function index(Request $request)
    {
        $products = Product::has('images')->has('sizes')->when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->when($request->city_id, function ($q) use ($request) {

            return $q->where('city_id', $request->city_id);

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->get();
        return $this->ApiResponse(true , [] , __('api.all_products') , ProductResource::collection($products) ,200);

    }

    public function get_all_by_city_id($id)
    {
        return $this->ApiResponse(true , [] , __('api.all_products') , ProductResource::collection(Product::where('city_id',$id)->get()->sortBy('sort')) ,200);
    }

    public function get_all_by_user_selection()
    {
        return $this->ApiResponse(true , [] , __('api.all_products') , ProductResource::collection(Product::where('city_id',request()->client->district->city->id)->get()) ,200);
    }

    public function get_one(Product $product)
    {
        //dd(request()->client);
        $data = new OneProductResource($product);
        
        return $this->ApiResponse(true , [] , __('api.all_products') , $data ,200);
    }

    public function get_latest_products()
    {
        $products = Product::has('images')->has('sizes')->latest()->take(10)->get();
//       return $this->ApiResponse(true , [] , __('api.all_products') , ProductResource::collection(Product::latest()->take(10)->get()) ,200);

        return $this->ApiResponse(true , [] , __('api.all_products') , ProductResource::collection($products) ,200);
    }
    public function get_most_ordered_products()
    {

        return $this->ApiResponse(true , [] , __('api.all_products') , ProductResource::collection(
            
            Product::where('orders','>','0')
            ->where('orders','>','0')
            ->orderBy('orders', 'DESC')
            ->take(10)
            ->get()
            
            ) ,200);
    }
}
