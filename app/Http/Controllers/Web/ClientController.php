<?php

namespace App\Http\Controllers\Web;

use App\City;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function login_form()
    {
        if(auth('client')->user()){
            return redirect()->route('web.index');
        }
        return view('web.auth.login');
    }

    public function login_post(){
        //dd(request()->all());
        if(Auth::guard('client')->attempt(['mobile' => request('phone'), 'password' => request('password')])){
            return redirect()->route('web.index');
        }else{
            return back();
        }
    }

    public function register_form()
    {
        $countries = City::all();
        return view('web.auth.register',compact('countries'));
    }

    public function register_post(){
        //dd(request()->all());
        request()->validate([
            'mobile'      => 'required|unique:clients',
            'email'       => 'required|unique:clients',
            'district_id' => 'required',
            'password'    => 'required|confirmed',
        ]);

        $data = request()->except(['password', 'password_confirmation' ,'city_id']);
        $data['password'] = bcrypt(request()->password);
        $data['active'] = 1;

        $client = Client::create($data);
        if($client)
        {    
            Auth::guard('client')->attempt(['mobile' => request('mobile'), 'password' => request('password')]);
            return redirect()->route('web.index');
        }
    }

}
