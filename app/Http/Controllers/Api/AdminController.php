<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\CartResource;

use App\Events\OrderStatusHasChanged;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    use ApiResponseTrait;
    public function login()
    {
        $data = [
            'email' => 'required',
            'password' => 'required',
        ];
        
        $validate = Validator::make(request()->all(),$data);

        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , [] ,200);
        }
        $credentials = request()->only('email', 'password');
 
        if(auth()->attempt($credentials))
        {
            $user = auth()->user();

            $user->api_token = str_random(100);
            $user->save();

            request()->admin = $user;
            return $this->ApiResponse(true , [] , __('auth.loggedin'), request()->admin ,200);
        }
        return $this->ApiResponse(true , [__('auth.failed')] , __('auth.failed'), [] ,200);
    }

    public function cc()
    {
        return request()->admin;
    }

    public function get_client_orders()
    {
        $orders = Order::latest()->get();
        return $this->ApiResponse(true , [] , __('site.orders') , OrderResource::collection($orders) ,200);
    }
        
    public function status()
    {
        $s = [
            'ar'=> [
                1 => 'في الانتظار',
                2 => 'جاري التحضير',
                3 => 'في الطريق',
                4 => 'تم التوصيل',
                0 => 'تم الرفض',
            ],
            'en'=>[
                1 => 'waiting',
                2 => 'preparing',
                3 => 'on way',
                4 => 'deleverd',
                0 => 'rejected',
            ]
        ];

        return $s[app()->getLocale()];
    }
    public function get_client_orders_by_status(Request $request)
    {
        $status = $this->status();

        if($request->status!=null)
        {
            $orders = Order::where('status', $request->status)
                    ->latest()->paginate(10);        
        }else{
         $orders = Order::latest()->paginate(10);           
        }

        return $this->ApiResponse(true , [] , __('site.orders') , OrderResource::collection($orders) ,200);
    }

    public function get_client_order_by_id($order)
    {
        $order =  Order::find($order);
        $carts = $this->process_order($order);
        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart->price;
        }
        $data =  [
            'order' => $order,
            'carts' => $carts,
            'total' => $total
        ];
        return $this->ApiResponse(true , [] , __('site.orders') ,$data ,200);
    }


    public function change_status($order)
    {
        $order =  Order::find($order);
        $data = [
            'status_id' => 'required|integer|min:0|max:4',
        ];
        
        $validate = Validator::make(request()->all(),$data);

        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , [] ,200);
        }

        $order->update([
            'status' => request()->status_id,
        ]);
        
        event(new OrderStatusHasChanged($order));

        return $this->ApiResponse(true , [] , __('site.orders') ,$order ,200);
    }

        
    public function process_order(Order $order)
    {
        $carts = $order->carts;
        $carts_id = explode(',' , $carts);

        $cart_objs = [];
        foreach($carts_id as $id)
        {
           array_push($cart_objs , new CartResource(Cart::find($id))); 
        }
        return $cart_objs;
    }
    
        public function update_token()
    {
        //return request()->fcm_token;
        $admin = request()->admin;
        $admin->update([
            'fcm_token' => request()->fcm_token
        ]);

        return $this->ApiResponse(true,[],__('site.client'),$admin,200);
    }

}
