<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\Rate;
use App\Tax;
use App\Size;


class ProductController extends Controller
{
    public function get_product(Product $product)
    {
        $related_products = Product::where('category_id',$product->category_id)
                            ->where('active',1)
                            ->where('id','!=',$product->id)
                            ->select('id','image')->get();
        //dd($related_products);
        $sizes = Size::where('quantity','>',0)->where('product_id',$product->id)->get();
        return view('web.products.index',compact('product','related_products','sizes'));
    }

    public function rate_product(Product $product , Order $order)
    {
        $delivery_cost = auth('client')->user()->district->delivered_cost;
        $tax = Tax::first()->tax;
        $location = explode(',',$order->location);
        $lat = $location[0];
        $lng = $location[1];

        if($product)
        {
            //check if not rate
            $rate = $product->is_rated_by_client(auth('client')->user());
            
            if($rate == false){
                Rate::Create([
                    'client_id' => auth('client')->user()->id,
                    'product_id' => $product->id,
                    'rate'    => \request()->rate,
                    'text'    => request()->text,
                ]);
                session()->flash('success', __('site.added_successfully'));
                return view('web.orders.order',compact('order','delivery_cost','tax','lat','lng'));
            }
            //update rate
            $rate->update([
                'client_id' => auth('client')->user()->id,
                'product_id' => $product->id,
                'rate'    => \request()->rate,
                'text'    => request()->text,
            ]); 
            session()->flash('success', __('site.updated_successfully'));
            return view('web.orders.order',compact('order','delivery_cost','tax','lat','lng'));        }
    }
}
