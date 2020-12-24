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