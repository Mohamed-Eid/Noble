<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        return $this->ApiResponse(true , [] , __('api.categories') , CategoryResource::collection(Category::all()) ,200);
    }
    
    public function products(Category $category)
    {
        $products = $category->products()->has('sizes')->where('active',1)->orderBy('sort')->latest()->get();
        return $this->ApiResponse(true , [] , __('api.categories') , ProductResource::collection($products) ,200);
    }
}
