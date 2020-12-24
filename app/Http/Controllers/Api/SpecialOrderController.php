<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Mail\SpecialOrderMail;
use Illuminate\Support\Facades\Mail;
use App\User;

class SpecialOrderController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('hiii');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd(request()->client);
        $validate = Validator::make(request()->all(),[
            'description'    => 'required',
            //'files'          => 'required|array|min:1',
        ]);
        
        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , [] ,200);
        }
        
        $data = [];
        foreach ($request->files->all()['files'] as $file) {
            $file_name = time() . $file->getClientOriginalName();                      
        
            $file_path = 'uploads/special_orders/';
        
            $file->move($file_path, $file_name);
            $data[] = $file_name;
        }
        
        
        $special_order = request()->client->special_orders()->create([
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
            return $this->ApiResponse(true , [] , __('api.done') , $special_order ,200);
        }
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
