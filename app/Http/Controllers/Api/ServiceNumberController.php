<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ServiceNumber;

class ServiceNumberController extends Controller
{
        use ApiResponseTrait;

    public function service_number()
    {
        $service_number = ServiceNumber::first();
        if($service_number)
            return $this->ApiResponse(true , [] , __('site.contact_details') ,$service_number,200);
        
        $service_number = ServiceNumber::create([
            'number' => '01000000000',
            'email' => 'test@test.com',
        ]);
        
        return $this->ApiResponse(true , [] , __('site.contact_details') ,$service_number ,200);

    }

    public function update(Request $request)
    {
        $rules = ['mobile' => 'required'];

        $service_number = ServiceNumber::first();

        $request->validate($rules);
      
        $service_number->update(
            [
                'number' => request()->mobile,
            ]
        );
        //return $about;
        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.service_number',compact('service_number'));
    }  
}
