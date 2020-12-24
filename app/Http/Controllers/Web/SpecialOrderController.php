<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\SpecialOrderMail;
use App\User;
use Illuminate\Support\Facades\Mail;

class SpecialOrderController extends Controller
{
    public function index()
    {
        return view('web.orders.special_order');
    }

    public function store(Request $request)
    {
        //dd(request()->client);
        
        request()->validate([
            'description'    => 'required',
            'file'           => 'required' 
        ]);
        
        $data = [];

        $file = request()->file;
        $file_name = time() . $file->getClientOriginalName();                      
    
        $file_path = 'uploads/special_orders/';
    
        $file->move($file_path, $file_name);
        $data[] = $file_name;
        
        
        $special_order = auth('client')->user()->special_orders()->create([
                'description' => request()->description,
                'files'       => $data
            ]);
        
        if($special_order)
        {
            //send email to admins 
            $admins = User::all();
            $emails = [];
            foreach ($admins as $admin) {
                if($admin->hasPermission('read_orders'))
                {
                    $user['email'] = $admin->email;
                    $emails[] = $user;
                }
            }
            //dd($emails);
            Mail::to($emails)->send(new SpecialOrderMail($special_order));
            //return
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('web.special_order');
        }
        
    }
}
