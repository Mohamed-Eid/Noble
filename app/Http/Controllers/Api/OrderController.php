<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\DelivertimeResource;
use App\Order;
use App\Product;
use App\Subdetail;
use App\Deliverytime;
use App\Http\Resources\ShoppingCartResource;
use App\ShoppingCart;
use App\Size;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Tax;
use App\Mail\NewOrderMail;


class OrderController extends Controller
{
    use ApiResponseTrait;


    private function get_sub_details($ids)
    {
        $subdetails = [];

        foreach ($ids as $id) {
        
            $subdetail = Subdetail::find($id);
            if(!$subdetail)
            {
                return $this->ApiResponse(true , [__('api.subdetail_not_found')] , __('api.subdetail_not_found') , [] ,200);
            }
            $subdetails[] = $subdetail;

        }
        return collect($subdetails);
    }

    private function find_subdetails_cost($sub_details)
    {
        $sub_details_price = 0;
        foreach ($sub_details as $subdetail) {
            $sub_details_price += $subdetail->price;
        }
        return $sub_details_price;
    }

    private function details_cart($sub_details)
    {
        $data = [];
        foreach ($sub_details as $subdetail) {
            $data[] = [
                "detail_id" => $subdetail->detail->id,
                "subdetail_id" => $subdetail->id
            ];
        }
        return $data;
    }

    public function add_to_cart(){
        return request()->all();
    }

    public function add_to_cart_old()
    {
        $client = request()->client;

        $product = Product::find(request()->product_id);
        
        if(!$product)
        {
            return $this->ApiResponse(true , [__('api.product_not_found')] , __('api.product_not_found') , [] ,200);
        }
        
        $size_cost = 0;
        if(request()->size_id)
        {
            $size  = Size::find(request()->size_id);
            if(!$size)
            {
                return $this->ApiResponse(true , [__('api.size_not_found')] , __('api.size_not_found') , [] ,200);
            }
            $size_cost = ($size->cost - ($product->discount/100*$size->cost));
        }

        $quantity = request()->quantity;
       
        $special_sizes = request()->special_sizes;
        $special_sizes_cost = 0;

        if($special_sizes != null)
        {
            //check if product have special sizes
            $special_sizes_cost = ($special_sizes['length'] /100 * $product->length_cost) +
                    ($special_sizes['width']  /100 * $product->width_cost)  +
                    ($special_sizes['height'] /100 * $product->height_cost) + 
                    ($special_sizes['depth']  /100 * $product->depth_cost);
        }



        $sub_details = $this->get_sub_details(request()->sub_details);
        $sub_details_price = $this->find_subdetails_cost($sub_details);

        $detail_cart = $this->details_cart($sub_details);

        $price = ($size_cost + $sub_details_price + $special_sizes_cost)*$quantity;
        
        //dd($price);
        
        $data = [
            'product_id'    => $product->id,
            'size_id'       => request()->size_id,
            'special_sizes' => $special_sizes,
            'quantity'      => $quantity,
            'price'         => $price,
            'details'       => $detail_cart,
        ];

        //return $data;

        $cart = $client->shopping_carts()->create($data);
        
        $cart->products_count = $client->shopping_carts->count();

        if($cart)
        {
            return $this->ApiResponse(true , [] , __('api.added_to_cart') , $cart ,200);
        }

        return $this->ApiResponse(true , [__('api.backend_error')] , __('api.backend_error') , [] ,200);

    }

    
    public function carts()
    {
        $client = request()->client;

        $carts = ShoppingCartResource::collection(ShoppingCart::where('client_id',$client->id)->where('checked','0')->get());
        
        $total_price=0;
        foreach($carts as $cart){
            $total_price += ($cart->price);

           // $total_price += ($cart->price*$cart->quantity);
        }
        
        $data = [
            'carts'              => $carts,
            'total_carts_price'  => $total_price,
            'tax'                => Tax::first()->tax,
            'delivery_cost'      => request()->client->district->delivered_cost,
            ];
            
        $data += [
                'total_price_after_adding_tax_and_delivery_cost' => $data['total_carts_price'] + $data['tax'] + $data['delivery_cost'],
            ];

        return $this->ApiResponse(true , [] , __('api.all_cart') , $data ,200);
    }
    
    // public function carts()
    // {
    //     $client = request()->client;

    //     $carts = ShoppingCartResource::collection(ShoppingCart::where('client_id',$client->id)->where('checked','0')->get());

    //     return $this->ApiResponse(true , [] , __('api.all_cart') , $carts ,200);

    // }

    public function delete_from_cart($cart)
    {
        $cart = ShoppingCart::find($cart);
        if($cart)
        {
            if($cart->checked == 1)
            {
                return $this->ApiResponse(true , [__('api.ordered_before')] , __('api.ordered_before') , [] ,200);  
            }
            if(request()->client != $cart->client)
            {
                return $this->ApiResponse(true , [__('api.access_denaied')] , __('api.access_denaied') , [] ,200);
            }else{
                $cart->delete();
                return $this->ApiResponse(true , [] , __('site.deleted_successfully'), ['products_count'=>request()->client->shopping_carts->count()] ,200);
            }
        }
        return $this->ApiResponse(true , [__('api.cart_not_found')] , __('api.cart_not_found') , [] ,200);
    }

    
    public function check_coupon()
    {
       // dd(request()->coupon);
        if(request()->coupon)
        {
           $coupon = Coupon::where('coupon',request()->coupon)->first();
            if($coupon){
                $coupon->expired = false;
                if(!$coupon->expire_date >= date('Y-m-d'))
                {
                    $coupon->expired = true;
                    return $this->ApiResponse(true , [__('site.coupon_expired')] , __('site.coupon_expired') , $coupon ,200);

                }else{
                    return $this->ApiResponse(true , [] , __('api.coupon') , $coupon ,200);
                }
            } else{
                return $this->ApiResponse(true , [__('site.coupon_not_found')] , __('site.coupon_not_found') , $coupon ,200);
 
            }
        }

    }
    
    public function checkout_old()
    {
        $client = request()->client;
        $validate = Validator::make(request()->all(),[
            'cart_id'    => 'required|array|min:1',
            'location' => 'required',
            'payment_method' => 'required'
        ]);
        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , [] ,200);
        }


        $carts = [];
        $total_cost = $client->district->delivered_cost + Tax::first()->tax;
        foreach(request()->cart_id as $id) {
            $cart = ShoppingCart::find($id);
            $cart = new ShoppingCartResource($cart);

            $carts[] = $cart;
            $total_cost += ($cart->price*$cart->quantity);
        }
       // return ($carts);
        $coupon = null;
        if(request()->coupon)
        {
            $coupon = Coupon::where('coupon',request()->coupon)->first();

            if($coupon && $coupon->expire_date >= date('Y-m-d'))
            {
                $total_cost -= $total_cost * ($coupon->offer/100);
            }
        }

        $order = $client->orders()->create([
            'carts' => $carts,
            'notes' => request()->notes,
            'status' => 1,
            'location' => request()->location,
            'payment_method' => request()->payment_method,
            'total_price'   => $total_cost,
            'discount' => $coupon == null ? 0 : $coupon->offer.' %',     
        ]);

        if($order)
        {      
            foreach ($carts as $cart) {
                $cart->product->orders += 1;
                $cart->product->save();
            }  
            foreach ($carts as $cart) {
                $cart->delete();
            }
            
            $this->send_mails_to_admins($order);
            
            return $this->ApiResponse(true , [] , __('api.ordered') , $order ,200);
        }
        
        return $this->ApiResponse(true , [__('api.backend_error')] , __('api.backend_error') , [] ,200);
    }



    private function calc_price_on_cart($items){

        $total_price = 0;
        foreach ($items as $item) {
            $size_cost = 0;

            $product = Product::find($item['product_id']);
        
            if(!$product)
            {
                return $this->ApiResponse(true , [__('api.product_not_found')] , __('api.product_not_found') , [] ,200);
            }

            if($item['size_id'] && $item['size_id']!=0)
            {
                $size  = Size::find($item['size_id']);
                
                if(!$size)
                {
                    return $this->ApiResponse(true , [__('api.size_not_found')] , __('api.size_not_found') , [] ,200);
                }

                $size_cost = ($size->cost - ($product->discount/100*$size->cost));
            }

            $quantity = $item['quantity'];
            
            $special_sizes = $item['special_sizes'] ?? null;
            $special_sizes_cost = 0;

            if($special_sizes != null)
            {
                //check if product have special sizes
                $special_sizes_cost = ($special_sizes['length'] /100 * $product->length_cost) +
                        ($special_sizes['width']  /100 * $product->width_cost)  +
                        ($special_sizes['height'] /100 * $product->height_cost) + 
                        ($special_sizes['depth']  /100 * $product->depth_cost);
            }

            $sub_details = $this->get_sub_details($item['sub_details']);

            $sub_details_price = $this->find_subdetails_cost($sub_details);

            $price = ($size_cost + $sub_details_price + $special_sizes_cost)*$quantity;

            $total_price += $price;
        }
        return ($total_price);
    }

    public function checkout()
    {
        $client = request()->client;
        
        $validate = Validator::make(request()->all(),[
            'location' => 'required',
            'items'    => 'required|array|min:1',
            'payment_method' => 'required'
        ]);
        
        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , [] ,200);
        }


        $total_cost =  0 ; //+ $client->district->delivered_cost //calc tax
        
        $items = request()->items;
        
        //return $items;

        
        $total_cost += $this->calc_price_on_cart($items);

       // return ($carts);
        
        $coupon = null;
        if(request()->coupon)
        {
            $coupon = Coupon::where('coupon',request()->coupon)->first();

            if($coupon && $coupon->expire_date >= date('Y-m-d'))
            {
                $total_cost -= $total_cost * ($coupon->offer/100);
            }
        }

        $order = $client->orders()->create([
            'carts' => $items,
            'notes' => request()->notes,
            'status' => 1,
            'location' => request()->location,
            'payment_method' => request()->payment_method,
            'total_price'   => $total_cost,
            'discount' => $coupon == null ? 0 : $coupon->offer.' %',     
        ]);

        return $this->ApiResponse(true , [] , __('api.ordered') , $order ,200);

        if($order)
        {      
            foreach ($items as $item) {
                $product = Product::find( $item['product_id'])->orders += 1;
                $product->save();
            }  
            
            $this->send_mails_to_admins($order);
            
            return $this->ApiResponse(true , [] , __('api.ordered') , $order ,200);
        }
        
        return $this->ApiResponse(true , [__('api.backend_error')] , __('api.backend_error') , [] ,200);
    }
    
    private function send_mails_to_admins($order)
    {
        $admins = User::all();
        $emails = [];
        foreach ($admins as $admin) {
            if($admin->hasPermission('read_orders'))
            {
                $user['email'] = $admin->email;
                $emails[] = $user;
            }
        }
        Mail::to($emails)->send(new NewOrderMail($order));
    }
    
    public function delivery_times()
    {
        return $this->ApiResponse(true , [] , __('site.delivery_times') , DelivertimeResource::collection(Deliverytime::all()) ,200);
    }
    
    public function get_client_orders()
    {
        $orders = Order::where('client_id',request()->client->id)->get();
        //return $orders;
        return $this->ApiResponse(true , [] , __('site.orders') , OrderResource::collection($orders) ,200);

    }

    public function get_client_order_by_id($order)
    {
        $order =  Order::find($order);
        if(!$order)
        {
            return $this->ApiResponse(true , [__('site.no_records')] , __('site.orders') ,[] ,200);
        }

        if(request()->client->id != $order->client_id)
        {
            return $this->ApiResponse(true , [__('api.access_denaied')] , __('api.access_denaied') , [] ,200);
        }
        
        $carts = $this->process_order($order);
        $total = 0;
        
        foreach ($carts as $cart) {
            $total += ($cart->quantity * $cart->price);
        }
        $data =  [
            'order'               => $order,
            'carts'               => $carts,
            'total'               => $total,
            'total_with_delivery' => $total + request()->client->district->delivered_cost,
        ];
        return $this->ApiResponse(true , [] , __('site.orders') ,$data ,200);


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


}