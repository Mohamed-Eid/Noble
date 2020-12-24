<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Client;

class Notification extends Model
{
    protected $fillable = ['title' , 'body' , 'image' , 'client_id'];
    protected  $appends = ['image_path','type'];

    
    public  function getImagePathAttribute(){
        return asset('uploads/notification_images/'.$this->image);
    }
    
    public function getTypeAttribute(){
        $s = [
            'ar'=> [
                1 => 'خاص',
                2 => 'عام',
            ],
            'en'=>[
                1 => 'private',
                2 => 'public',
            ]
        ];

        if($this->client_id != null)
        {
            return $s[app()->getLocale()][1];
        }
        return $s[app()->getLocale()][2];

    }
    
}
