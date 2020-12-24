<?php

namespace App\Http\Controllers\Dashboard;

use App\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function index(){
        $coupon_edit = false;

        $coupons = Coupon::all();
        return view('dashboard.coupons.index', compact('coupons','coupon_edit'));
    }
    public function add_coupons()
    {
        //dd(request()->all());
        request()->validate([
            'coupon' => 'required',
            'offer' => 'required|min:0|max:100',
            'expire_date' => 'required',
        ]);

        Coupon::create(request()->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.coupons.index');
    }

    public function edit_coupons(Coupon $coupon)
    {
        $coupon_edit = true;
        $coupons = Coupon::all();

        return view('dashboard.coupons.index' , compact('coupon_edit','coupon','coupons'));

    }

    public function update_coupons(Coupon $coupon)
    {
        request()->validate([
            'coupon' => 'required',
            'offer' => 'required|min:0|max:100',
            'expire_date' => 'required',
        ]);
        
        $coupon->update(request()->all());
        
        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.coupons.index');

    }


    public function delete_coupons(Coupon $coupon)
    {
        //dd($color);

        $coupon->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.coupons.index');

    }
}
  