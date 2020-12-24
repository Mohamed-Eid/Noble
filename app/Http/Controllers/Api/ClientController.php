<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;
use App\District;
use App\Notification;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ClientResource;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    use ApiResponseTrait;

    
    public function register_client(Request $request)
    {
        // dd(request()->all());

        $validate = Validator::make(request()->all(),[
            'mobile'      => 'required|unique:clients',
            'email'       => 'required|unique:clients',
            'district_id' => 'required',
            'password'    => 'required|confirmed',
        ]);

        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , (object)[] ,200);
        }

        $data = $request->except(['password', 'password_confirmation' ]);
        $data['password'] = bcrypt($request->password);
        $data['active'] = 1;


        $client = Client::create($data);
        if($client)
        {
            $client->api_token = str_random(100);
            $client->save();
            
            $this->send_active_code($client);
            
            return $this->ApiResponse(true , [] , __('api.client') , new ClientResource($client) ,200);
        }
        return $this->ApiResponse(true , [__('api.back_end_error')] , __('api.back_end_error') , (object)[] ,200);

    }


    public function send_active_code(Client $client)
    {
        //generate random code
        $active_code = mt_rand(10000, 99999);

        //put the activation code in the db
        $client->codes()->create([
            'code' => $active_code,
        ]);
    }

    public function activate_client(Client $client)
    {
        $validate = Validator::make(request()->all(),[
            'code' => 'required',
        ]);

        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , [] ,200);
        }

        $codes = $client->codes->where('code',request()->code);
                
        
        //if active code is correct then :
        if($codes){
            //update active field in client table 
            $client->active = 1;
            $client->save();
            
            //delete all codes with this client in the codes table
            $client->codes()->delete();

            return $this->ApiResponse(true , [] , __('api.client') , new ClientResource($client) ,200);

        }
            
        //else return validation error
        return $this->ApiResponse(true , [__('api.activation_code_wrong')] , __('api.client') , new ClientResource($client) ,200);
    }

    public function get_activation_codes(Client $client)
    {
      return $this->ApiResponse(true , [] , __('api.client') , $client->codes ,200);  
    }
    
    public function notifications()
    {
        $client = request()->client;
        //dd($client);
        return $this->ApiResponse(true , [] , __('api.client') , NotificationResource::collection($client->notifications()) ,200);
      //return $this->ApiResponse(true , [] , __('api.client') , NotificationResource::collection(Notification::all()) ,200);  
    }

    public function login()
    {
        $validate = Validator::make(request()->all(),[
            'mobile' => 'required',
            'password' => 'required',
        ]);

        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , (object)[] ,200);
        }
        
        $client = Client::where('mobile',request()->mobile)->first();

        if($client)
        {
            if(Hash::check(request()->password, $client->password) && $client->active_status == 1)
            {
                $client->api_token = str_random(100);
                $client->save();
                return $this->ApiResponse(true , [] , __('api.login') , new ClientResource($client) ,200);
            }              
        }

        return $this->ApiResponse(true , [__('auth.failed')] , __('auth.failed'), (object)[] ,200);


    }
  

    public function profile()
    {
        $client = request()->client;

        return $this->ApiResponse(true , [] , __('api.profile') , new ClientResource($client) ,200);
    }

    public function update_profile()
    {
        $client = request()->client;
        $rules = [
            'district_id' => 'required',
            'street' => 'required',
            
            ];
        $rules += [
            'mobile' => ['required' ,Rule::unique('clients','mobile')->ignore($client->mobile,'mobile')],
            'email'  => ['required' ,Rule::unique('clients','email')->ignore($client->email,'email')]
        ];
        
        $validate = Validator::make(request()->all(),$rules);

        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , (object)[] ,200);
        }

        $client->update(request()->all());
        
        return $this->ApiResponse(true , [] , __('api.profile') , new ClientResource($client) ,200);

    }

    public function update_fcm_token()
    {
        $validate = Validator::make(request()->all(),[
            'fcm_token' => 'required',
        ]);

        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , [] ,200);
        }
        

        $client = request()->client;
        $client->update([
            'fcm_token' => request()->fcm_token
        ]);

        return $this->ApiResponse(true , [] , __('api.upfate_token') , new ClientResource($client) ,200);
    }
    

    public function change_password()
    {
        //validateion
        $validate = Validator::make(request()->all(), [
            'old_password' => 'required',
            'new_password'     => 'required',
        ]);
        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , [] ,200);
        }


        $client = request()->client;

        if(Hash::check(request()->old_password, $client->password))
        {
            $client->update([
                'password' => bcrypt(request()->new_password),
            ]);
            return $this->ApiResponse(true , [] , __('api.password_changed') , [] ,200);
        }
        return $this->ApiResponse(true , [__('api.wrong_password')] , __('api.wrong_password'), [] ,200);


    }


    public function forget_password()
    {
        //check email
        $validate = Validator::make(request()->all(), [
            'email' => 'required',
        ]);
        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , [] ,200);
        }
        
        //check if this email exist
        
        $client = Client::where('email',request()->email)->first();

        if($client){
            //generate random code
            $active_code = mt_rand(10000, 99999);
            
            //send mail
            Mail::to($client->email)->send(new ForgetPasswordMail($active_code));
           
            //put the activation code in the db
            $client->codes()->create([
                'code' => $active_code,
            ]);
            return $this->ApiResponse(true , [] , __('api.code_has_beet_sent_to_email') , [] ,200);
        }
        return $this->ApiResponse(true , __('api.email_not_exist') , __('api.email_not_exist') , [] ,200);
    }
    
    public function check_forget_code()
    {
        //validation
        $validate = Validator::make(request()->all(), [
            'email' => 'required',
            'code' => 'required',
        ]);
        if($validate->fails())
        {
            return $this->ApiResponse(true , [__('api.validation_error')], __('api.validation_error') , [] ,200);
        }  
        $client = Client::where('email',request()->email)->first();
        if($client){
            $codes = $client->codes->where('code',request()->code);
            if($codes){
                $client->codes()->delete();
                 return $this->ApiResponse(true , [], __('api.success') , [] ,200);
            }
         return $this->ApiResponse(true , [__('api.code_not_exist')], __('api.code_not_exist') , [] ,200);

        }
        return $this->ApiResponse(true , [__('api.email_not_exist')], __('api.email_not_exist') , [] ,200);
    }
    
    public function renew_password()
    {
        $validate = Validator::make(request()->all(),[
            'email'       => 'required',
            'password'    => 'required|confirmed',
        ]); 
        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , [] ,200);
        }
        
        $client = Client::where('email',request()->email)->first();

        $client->update([
            'password' => bcrypt(request()->password),
        ]);
        return $this->ApiResponse(true , [] , __('api.password_changed') , [] ,200);
    }

    public function update_locale()
    {
        $validate = Validator::make(request()->all(),[
            'locale' => 'required'
        ]);

        if($validate->fails())
        {
            return $this->ApiResponse(true , $validate->errors()->all() , __('api.validation_error') , (object)[] ,200);
        }
        
        $client = request()->client;
        $client->update([
            'locale' => request()->locale
        ]);
        
        if($client){
                    return $this->ApiResponse(true,[],__('site.client'),$client,200);
        }
    }
    
}
