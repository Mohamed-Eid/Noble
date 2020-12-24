<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tax;

class TaxController extends Controller
{
    public function index()
    {
        $tax = Tax::first();
        if($tax)
            //return $about;
           return view('dashboard.tax.edit',compact('tax'));
        
        $tax = Tax::create([
            'tax' => 0,
        ]);
        return view('dashboard.tax.edit',compact('tax'));
    }

    public function update(Request $request)
    {
        $rules = [
            'tax' => 'required'
        ];

        $tax = Tax::first();

        $request->validate($rules);
      
        $tax->update([
            'tax' => \request()->tax,
        ]
        );
        //return $about;
        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.tax',compact('tax'));
    }
}
