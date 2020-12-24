<?php

namespace App\Http\Controllers\Dashboard;

use App\City;
use App\Client;
use App\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\User;
use Activity;

class DashboardController extends Controller
{
    public function index(){
        $products_count   = Product::count();
        $cities_count     = City::count();
        $orders_count     = Order::count();
        $districts_count  = District::count();
        $clients_count    = Client::count();
        $users_count      = User::whereRoleIs('admin')->count();
        $orders_waiting   = Order::waiting()->count();
        $active_users     = $this->active_users_data();
        // $active_users     = $this->active_users_data2();
        return view('dashboard.index' , compact('orders_count','products_count','cities_count','districts_count','clients_count','users_count','orders_waiting','active_users'));
    }
    
    private function active_users_data(){
        $data = [];
        $active_users = Activity::guestsByMinutes(1)->get();
        //return $active_users;
        foreach($active_users as $user)
        {
            $ipdat = @json_decode(file_get_contents( 
                        "https://api.ipdata.co/" . $user->ip_address."?api-key=".env('IP_DATA_KEY'))); 
            if($ipdat != null){
                $data[] = [
                        'ip' => $user->ip_address,
                        'country' =>  $ipdat->country_name,
                        'city'           => $ipdat->city,
                        'flag'           => $ipdat->flag,
                        'location'       => $ipdat->latitude .','.$ipdat->longitude,
                        'time_zone'      => $ipdat->time_zone,
                    ]; 
            }else{
                $data[] = [
                    'ip' => $user->ip_address,
                    'country' =>  'error',
                    'city'           => 'error',
                    'location'       => 'error',
                    'time_zone'      => 'error',
                ];
            }
        }
        
        return $data;

    }

    private function active_users_data2(){
        $data = [];
        $active_users = Activity::guestsByMinutes(3)->get();
        //return $active_users;
        foreach($active_users as $user)
        {
            $ipdat = @json_decode(file_get_contents( 
                        "https://api.userinfo.io/userinfos?ip_address={$user->ip_address}"
                        )); 
                        
                        dd($ipdat);
            if($ipdat != null){
                $data[] = [
                        'ip' => $user->ip_address,
                        'country' =>  $ipdat->country_name,
                        'city'           => $ipdat->city,
                        'flag'           => $ipdat->flag,
                        'location'       => $ipdat->latitude .','.$ipdat->longitude,
                        'time_zone'      => $ipdat->time_zone,
                    ]; 
            }else{
                $data[] = [
                    'ip' => $user->ip_address,
                    'country' =>  'error',
                    'city'           => 'error',
                    'location'       => 'error',
                    'time_zone'      => 'error',
                ];
            }
        }
        
        return $data;

    }
}
