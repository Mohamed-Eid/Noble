<?php

namespace App\Http\Controllers\Dashboard;

use App\City;
use App\District;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Member;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_members'])->only('index');
    }
    public function index(Request $request){
        //$members = Member::paginate(10);
        $members = Client::paginate(10);
        $cities = City::all();
        //dd($status);
        // $members = Member::when($request->city_id, function ($q) use ($request){
        //     return $q->join('clients','members.client_id','clients.id')
        //     ->join('districts','clients.district_id','districts.id')
        //     ->select('members.*')
        //     ->where('city_id',$request->city_id);
        // })->latest()->paginate(10);
        $members = Client::when($request->city_id, function ($q) use ($request){
            return $q->join('districts','clients.district_id','districts.id')
            ->select('clients.*')
            ->where('city_id',$request->city_id);
        })->latest()->paginate(10);

        return view('dashboard.members.index',compact('members','cities'));
    }
    
    public function show(Client $client){
        $orders = $client->orders()->paginate(5);
        return view('dashboard.members.show',compact('client','orders'));
    }
    
    public function edit(Client $client){
         $cities = City::all();
         $districts = District::all();
        return view('dashboard.members.edit',compact('client','cities','districts'));
    }
    
    public function update(Client $client){
        request()->validate([
                'mobile' => 'required',
                'city_id' => 'required',
                'district_id' => 'required',
                'street' => 'required',
            ]);
        
        $data = request()->all();

        unset($data['city_id']);

        if(isset($data['active'])){
            $data['active'] = 1;  
        }else{
           $data['active'] = 0; 
        }

        $client->update($data);
        
        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.members.index');    
        
    }
    
    public function delete(Client $client){
        $client->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.members.index');
    }
    
    public function update_password(Client $client)
    {
        request()->validate([
            'password' => 'required|confirmed',
        ]);
        $data = $request->except(['password', 'password_confirmation']);
        $data['password'] = bcrypt($request->password);
        $client->update($data);
    }
    
}
