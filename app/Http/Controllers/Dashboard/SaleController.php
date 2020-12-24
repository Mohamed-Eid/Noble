<?php

namespace App\Http\Controllers\Dashboard;

use App\Cart;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;

class SaleController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['permission:read_sales'])->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        
        //dd($total .' - '.calc_tax_on_price($total));
        

        $cities = City::all();

        $id = $request->city_id ?? City::first()->id;

        if(!$request->city_id)
        {
            $request->city_id =  City::first()->id;
        }

        $currency = City::find($id)->translate(app()->getLocale())->currency;
        //dd($currency);

        $orders = Order::when($request->city_id , function ($q) use ($request) {
                return $q->join('clients','orders.client_id','clients.id')
                ->join('districts','clients.district_id','districts.id')
                ->select('orders.*')
                ->where('city_id',$request->city_id);
            })->get();
        
        //return ($orders);
        
        $profit = 0;
        
        foreach($orders as $order){
            foreach($order->carts as $cart){
                $profit += Product::find($cart["product"]["id"])->profit;
               // dd($profit);
            }   
        }
        
        $total = Order::sum('total_price');
        
        //$profit = calc_tax_on_price($total) ;

        return view('dashboard.sales.index' , compact('orders' ,'cities' , 'profit','currency' ,'total'));
    }


}
