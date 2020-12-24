<?php

namespace App\Listeners;

use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;

class NotifyTheAdmin
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $this->send_notification();
    }

    public function send_notification()
    {
        $admins = User::all();
        $tokens = [];
        foreach($admins as $user)
        {
            array_push($tokens,$user->fcm_token);
        }

        $sourceKey = env('FIREBASE_FCM_KEY');
        $header = [
            'Authorization'=> 'key=' . $sourceKey,
            'Content-Type' => 'application/json'
        ];
        $body = [
            'data'=> [
                'title' => __('site.notification_title_admin'),
                'body'  => 'new order',
                //'image' => $data->image,
                'content-available'=>1,
                'sound' => 'default'
            ] , 
            'notification' => [
                'title' => __('site.notification_title_admin'),
                'body'  => 'new order',
                'content-available'=>1,
                //'image' => $data->image,
                'sound' => 'default'
            ],
            //'to' => $tokens[0]
            'registration_ids' => $tokens
        ];

        $client = new Client(['headers' => $header]);
        
        $res = $client->post('https://fcm.googleapis.com/fcm/send',[
            'body' => json_encode($body),
        ]);
        //dd(json_decode($res->getBody()));
    }
}
