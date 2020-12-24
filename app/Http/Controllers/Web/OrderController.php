<?php

namespace App\Http\Controllers\web;

use App\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShoppingCartResource;
use App\Order;
use App\Product;
use App\ShoppingCart;
use App\Size;
use App\Subdetail;
use App\Tax;
use App\Coupon;

class OrderController extends Controller
{

    
    private function get_sub_details($ids)
    {
        $subdetails = [];
        foreach ($ids as $id) {
            $subdetail = Subdetail::find($id);
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

    public function add_to_cart()
    {
        //dd(request()->all());
        $product = Product::find(request()->product_id);
                
        $size_cost = 0;


        $quantity = request()->quantity;
      
        $special_sizes = request()->special_sizes;
        $special_sizes_cost = 0;

        if(request()->special_sizes_btn == 1){
            if($special_sizes != null)
            {
                request()->size_id = null;
                //check if product have special sizes
                $special_sizes_cost = (($special_sizes['length'] ?? 0) * $product->length_cost) +
                        (($special_sizes['width'] ?? 0) * $product->width_cost)  +
                        (($special_sizes['height'] ?? 0) * $product->height_cost) + 
                        (($special_sizes['depth'] ?? 0) * $product->depth_cost);
                        //dd($special_sizes_cost);
            }      
        }else{
            if(request()->size_id)
            {
                $size  = Size::find(request()->size_id);
                $size_cost = ($size->cost - ($product->discount/100*$size->cost));
                $special_sizes = null;
                if($size->quantity < $quantity){
                    session()->flash('error', __('site.not_enough_quantity'));
                    return redirect()->back();    
                }
            }
        }




        $request_sub_details = request()->sub_details ?? [];
        $sub_details = $this->get_sub_details($request_sub_details);
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
        if(request()->special_sizes_btn == 1){
            unset($data['size_id']);
        }
        $client = auth('client')->user();

        $cart = $client->shopping_carts()->create($data);
        
        $cart->products_count = $client->shopping_carts->count();

        if($cart)
        {
            //dd($cart);
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('web.index');
        }

        return $this->ApiResponse(true , [__('api.backend_error')] , __('api.backend_error') , [] ,200);
    }

    public function carts()
    {


        $client = auth('client')->user();

        $banks = Bank::all();
        $carts = ShoppingCartResource::collection(ShoppingCart::where('client_id',$client->id)->where('checked','0')->get());
        
        $total_price=0;
        foreach($carts as $cart){
            // $total_price += ($cart->price*$cart->quantity);
            $total_price += ($cart->price);

        }
        
        $data = [
            'carts'              => $carts,
            'total_carts_price'  => $total_price,
            'tax'                => calc_tax_on_price($total_price),
            'delivery_cost'      => $client->district->delivered_cost,
            ];
        
        //return (json_decode(json_encode($data),true)['carts'][0]['cart_data']);
        $data += [
                'total_price_after_adding_tax_and_delivery_cost' => $data['total_carts_price'] + $data['tax'] + $data['delivery_cost'],
            ];

       // return $data;
        $data = json_decode(json_encode($data),true);
        //return $data;
        $total_carts_price = $data['total_carts_price'];
        $tax = $data['tax'];
        $delivery_cost = $data['delivery_cost'];
        $total_price_after_adding_tax_and_delivery_cost = $data['total_price_after_adding_tax_and_delivery_cost'];
        return view('web.orders.carts',compact('banks','data','total_carts_price','tax','delivery_cost','total_price_after_adding_tax_and_delivery_cost'));

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
    
    public function checkout_form($data){
        $client = auth('client')->user();

        $carts = ShoppingCartResource::collection(ShoppingCart::where('client_id',$client->id)->where('checked','0')->get());

        return view('web.orders.charge',compact('data','carts'));
    }


    private function process_order($request_data)
    {
        $client = auth('client')->user();
        $carts = [];
        $total_cost = $client->district->delivered_cost;

        $carts_data = ShoppingCartResource::collection(ShoppingCart::where('client_id',$client->id)->where('checked','0')->get());
        return $carts_data;
        foreach($carts_data as $cart) {
            $carts[] = $cart;
            $total_cost += ($cart->price*$cart->quantity);
        }
        $coupon = null;
        if(isset($request_data['coupon']) && $request_data['coupon']!=null)
        {
            $coupon = Coupon::where('coupon',$request_data['coupon'])->first();

            if($coupon && $coupon->expire_date >= date('Y-m-d'))
            {
                $total_cost -= $total_cost * ($coupon->offer/100);
            }
        }

        $total_cost = $total_cost + calc_tax_on_price($total_cost);

        $data = [
            'carts' => $carts,
            'notes' => $request_data['notes'],
            'status' => 1,
            'location' => $request_data['location'],
            'payment_method' => 2,
            'total_price'   => $total_cost,
            'discount' => $coupon == null ? 0 : $coupon->offer.' %',     
        ];

        return $data;
    }

    public function charge(){

        $data = request()->session()->get('cart_data');
        
        $check_delete = $this->delete_quantity($data);
        if(!$check_delete)
        {
            session()->flash('error', __('site.not_enough_quantity'));
            return redirect()->back();  
        }
        
        $data = $this->process_order($data);
        //dd($data);
        $curl = curl_init();
        $price = $data['total_price'];
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.tap.company/v2/charges",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING  => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT   => 40,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => 
          "{\"amount\":".$price.",
            \"currency\":".auth('client')->user()->district->city->translate('en')->currency.",
            \"threeDSecure\":true,
            \"save_card\":false,
            \"description\":\"test description\",
            \"statement_descriptor\":\"sample\",
            \"metadata\":{\"udf1\":\"test\"},
            \"reference\":{\"transaction\":\"txn_0001\",\"order\":\"test\"},
            \"receipt\":{\"email\":true,\"sms\":true},
            \"customer\":{\"first_name\":\"".auth('client')->user()->email."\",
                \"middle_name\":\"".auth('client')->user()->mobile."\",
                \"last_name\":\" ". auth('client')->user()->mobile ."\",
                \"email\":\"".auth('client')->user()->email."\",
                \"phone\":{\"country_code\":\"".auth('client')->user()->district->city->code."\",
                        \"number\":\"".auth('client')->user()->mobile."\",
                        \"city\":\"".auth('client')->user()->district->city->code."\"}},
            \"source\":{\"id\":\"".request()->tapToken."\"},
            \"auto\":{\"type\":\"VOID\",\"time\":100},
            \"post\":{\"url\":\"http://90days-home.com/charging\"},
            \"redirect\":{\"url\":\"".route('web.redirect_after_payment')."\"}}",
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer ".env('TAP_SECRET_KEY')."",
            "content-type: application/json"
          ),
        ));
        
        $chargeresponse = curl_exec($curl);
        $err            = curl_error($curl);
        
        //return $chargeresponse;
        
        curl_close($curl);
        
        
        if ($err) {
            session()->flash('error','للأسف فشل ف عملية الدفع');
            return back();
          //echo "cURL Error #:" . $err;
        } 
        else {
            $resultarray = json_decode($chargeresponse, true);
            if(count($resultarray) == 1)
            {
                session()->flash('error','للأسف فشل ف عملية الدفع');
                return back();
            }
        }
        //dd($resultarray);
        return \Illuminate\Support\Facades\Redirect::to($resultarray['transaction']['url'])->with('data', $data);

    }

    public function redirecturl()
    {        

        $chargeid    =  request()->input('tap_id');
        
        //dd($chargeid);
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.tap.company/v2/charges/".$chargeid,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 40,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "{}",
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer ".env('TAP_SECRET_KEY').""
          ),
        ));
        
        $chargeresponse = curl_exec($curl);

        curl_close($curl);
        
        $res = json_decode($chargeresponse, true);
        //dd($res);
        //dd(request()->session()->get('cart_data'));
        if(array_key_exists("errors",$res)){
           session()->flash('error', __('site.payment_failed'));
           return redirect()->route('web.cart');
        }

        
      $respocode =  $res['response']['code'];
        //dd($respocode);
      if($respocode == 000 || $respocode == 001 || $respocode == 100)
      {
            //success code  hear
            $client = auth('client')->user();
            
            // $data = request()->session()->pull('cart_data');
            $data = request()->session()->pull('cart_data');
            //dd($data);
            $check_delete = $this->delete_quantity($data);
            //dd($check_delete);
            if(!$check_delete)
            {
                session()->flash('error', __('site.not_enough_quantity'));
                return redirect()->back();  
            }
            
            //$data = $this->process_order($data);

            //dd($data);

            $order = $client->orders()->create($data);

            $carts = $data['carts'];

            if($order)
            {      
                foreach ($carts as $cart) {
                    $cart->product->orders += 1;
                    $cart->product->save();
                }  
                foreach ($carts as $cart) {
                    $cart->delete();
                }    
                //$this->send_mails_to_admins($order);
                session()->flash('success', __('site.payment_success'));
                return redirect()->route('web.index');
            }

      }
      else 
      {
          session()->flash('error', __('site.payment_failed').$res['response']['message']);
          return redirect()->route('web.cart');
      }
    }

    private function delete_quantity($data)
    {
        $flag = true;
        foreach($data['carts'] as $cart){
          if($cart->size_id != null)
            {
                $size  = Size::find($cart->size_id);

                if($size->quantity < $cart->quantity){
                    $flag = false;
                }else{
                    $size->quantity = $size->quantity - $cart->quantity;
                    $size->save();                    
                }

            }  
        }

        return $flag;
    }

    public function validate_checkout(){
        request()->validate([
            'lat' => 'required',
            //'lng' => 'required',
            'location' => 'required',
            'payment_method' => 'required'
        ]);  
    }

    public function checkout()
    {
        $client = auth('client')->user();
        $location =  request()->location;
        if(request()->lat != null && request()->lng != null ){
            $location = request()->lat.','.request()->lng;
        }

        request()->validate([
            'lat' => 'required',
            //'lng' => 'required',
            'location' => 'required',
            'payment_method' => 'required'
        ]);

        $carts = [];
        $total_cost = $client->district->delivered_cost;

        $carts_data = ShoppingCartResource::collection(ShoppingCart::where('client_id',$client->id)->where('checked','0')->get());
        foreach($carts_data as $cart) {
            $carts[] = $cart;
            $total_cost += ($cart->price*$cart->quantity);
        }

        $coupon = null;
        if(request()->coupon)
        {
            $coupon = Coupon::where('coupon',request()->coupon)->first();

            if($coupon && $coupon->expire_date >= date('Y-m-d'))
            {
                $total_cost -= $total_cost * ($coupon->offer/100);
            }
        }

        $total_cost = $total_cost + calc_tax_on_price($total_cost);


        $data = [
            'carts' => $carts,
            'notes' => request()->notes,
            'status' => 1,
            'location' => $location,
            'payment_method' => request()->payment_method,
            'total_price'   => $total_cost,
            'discount' => $coupon == null ? 0 : $coupon->offer.' %',     
        ];
        
        //TODO : $check_delete = $this->delete_quantity($data);
        //if(!$check_delete)
        //{
          //  session()->flash('error', __('site.not_enough_quantity'));
            //return redirect()->back();  
        //}
         //return ($data['carts'][0]);
        if($data['payment_method'] == 2)
        {
            request()->session()->put('cart_data', $data);
            return $this->checkout_form($data);
        }

        $order = $client->orders()->create($data);


        if($order)
        {      
            foreach ($carts as $cart) {
                $cart->product->orders += 1;
                $cart->product->save();
            }  
            foreach ($carts as $cart) {
                $cart->delete();
            }
            
            //$this->send_mails_to_admins($order);
            
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('web.index');        
        }
        
        return  __('api.backend_error');
    }

    public function delete_from_cart(ShoppingCart $cart)
    {
        //$cart = ShoppingCart::find($cart);
        if($cart)
        {
            if(auth('client')->user() != $cart->client)
            {
                return redirect()->bach()->withErrors(['msg',__('api.access_denaied')  ]);;
            }else{
                $cart->delete();
                return redirect()->back();
            }
        }
        return $this->ApiResponse(true , [__('api.cart_not_found')] , __('api.cart_not_found') , [] ,200);
    }


    public function my_orders()
    {
        $orders =  auth('client')->user()->orders()->latest()->get();
        return view('web.orders.orders',compact('orders'));
    }

    public function get_order(Order $order)
    {
        //return $order;
        // $data = $order;
        // return $data;
        $delivery_cost = auth('client')->user()->district->delivered_cost;
        $tax = Tax::first()->tax;
        $location = explode(',',$order->location);
        $lat = $location[0];
        $lng = $location[1];
        return view('web.orders.order',compact('order','delivery_cost','tax','lat','lng'));
    }

}
