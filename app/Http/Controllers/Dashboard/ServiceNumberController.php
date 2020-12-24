<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ServiceNumber;

class ServiceNumberController extends Controller
{    
    public function __construct()
    {
        $this->middleware(['permission:read_service_numbers'])->only('service_number');
        $this->middleware(['permission:update_service_numbers'])->only('update');
    }
    
    public function service_number()
    {
        $service_number = ServiceNumber::first();
        if($service_number)
            //return $about;
           return view('dashboard.service_number.edit',compact('service_number'));
        
        $service_number = ServiceNumber::create([
            'number' => '01000000000',
            'email'  => 'test@test.com',
        ]);
        return view('dashboard.service_number.edit',compact('service_number'));
    }

    public function update(Request $request)
    {
        $rules = [
            'mobile' => 'required',
            'email' => 'required|email'
            ];

        $service_number = ServiceNumber::first();

        $request->validate($rules);
      
        $service_number->update(
            [
                'number' => request()->mobile,
                'email'  => request()->email,
            ]
        );
        //return $about;
        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.service_number',compact('service_number'));
    }  
}
