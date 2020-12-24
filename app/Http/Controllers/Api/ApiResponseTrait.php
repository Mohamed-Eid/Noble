<?php 

namespace App\Http\Controllers\Api;

use App\Client;

trait ApiResponseTrait{

    public function ApiResponse(bool $status = true ,$errors = [] ,$message ,$data = []  ,int $code = 200)
    {

        $array = [
            'status'  => $this->status($errors) && $status,
            'message' => $message,
            'errors'  => $this->errors($errors), 
            'data'    => $data ? $data : []
        ];
        return response($array , $code);
    }
 

    private function find_client()
    {
        $token = request()->header('x-api-key');
        $client = Client::where('api_token',$token)->first();

        return $client;
    }

    // public function get_shopping_cart_items_count()
    // {
    //    $count = 0;
    //    if(request()->client)
    //    {
           
    //        $count = request()->client->shopping_carts->count();
    //    }
    //    return $count;
    // }   
    
    // public function get_shopping_cart_items_count_v2()
    // {
    //     $count = 0;
        
    //     $client = $this->find_client();
    //     if($client){
    //        $count = $client->shopping_carts->count();
    //     }

    //     return $count;
    // }

    public function errors($errors)
    {
       return $this->status($errors) ? (array)[] : $errors;
    }

    public function status($errors)
    {
        return $errors ? false : true;
    }
}

?>