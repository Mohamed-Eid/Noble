<?php

namespace App\Http\Controllers\Dashboard;

use App\Cart;
use App\City;
use App\Order;
use App\Events\OrderStatusHasChanged;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_orders'])->only('index');
        $this->middleware(['permission:update_orders'])->only('update');
        $this->middleware(['permission:delete_orders'])->only('destroy');

    }
    
    public function tafsil()
    {
        $status = $this->status();
        $cities = City::all();
        //return (Order::first());
        $orders = Order::whereJsonContains('carts',['special_sizes'=> true])->paginate(10);
        return $orders;
        
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $this->status();
        $cities = City::all();
        
        if($request->city_id && ($request->district_id==null || $request->district_id==''))
        {
            $orders = Order::when($request->search, function ($q) use ($request) {

                return $q->where('mobile', '%' . $request->search . '%');
    
            })->when($request->status, function ($q) use ($request) {
    
                return $q->where('status', $request->status);
    
            })->when($request->city_id, function ($q) use ($request) {
    
                //return DB::table('orders')
                return $q->join('clients','orders.client_id','clients.id')
                ->join('districts','clients.district_id','districts.id')
                ->select('orders.*')
                ->where('city_id',$request->city_id);
            })->latest()->paginate(10);
    
            return view('dashboard.orders.index' , compact('orders' , 'status','cities'));           
        }

        $orders = Order::when($request->status, function ($q) use ($request) {

            return $q->where('status', $request->status);

        })->when($request->client_id, function ($q) use ($request) {

            return $q->where('client_id', $request->client_id);

        })->when($request->tafsil, function ($q) use ($request) {

            return $q->whereJsonContains('carts',['special_sizes'=> true]);

        })->when($request->district_id, function ($q) use ($request) {
            return $q->join('clients','orders.client_id','clients.id')
            ->select('orders.*')
            ->where('district_id',$request->district_id);
        })->latest()->paginate(10);
        
        return view('dashboard.orders.index' , compact('orders' , 'status','cities'));
    }


    public function status()
    {
        $s = [
            'ar'=> [
                1 => 'في الانتظار',
                2 => 'تم الشحن',
                3 => 'تم التوصيل',
            ],
            'en'=>[
                1 => 'Waiting',
                2 => 'Shipping Done',
                3 => 'Transported',
            ]
        ];

        return $s[app()->getLocale()];
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
       // return ($order);
        return view('dashboard.orders.show' , compact('order'));
    }

    public function process_order(Order $order)
    {
        $carts = $order->carts;
        $carts_id = explode(',' , $carts);

        $cart_objs = [];
        foreach($carts_id as $id)
        {
           array_push($cart_objs , Cart::find($id)); 
        }
        return $cart_objs;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update([
            'status' => request()->status,
        ]);
        session()->flash('success', __('site.updated_successfully'));
        
        event(new OrderStatusHasChanged($order));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.orders.index');
    }
}
