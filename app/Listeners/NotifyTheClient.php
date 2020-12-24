<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;
use App\Notification;

class NotifyTheClient
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
       // $this->test($event->order);
        $this->send_notification($event->order); 
    }
    

    public function test($order)
    {
        //set to client locale
        $devlocale = app()->getLocale();
        app()->setLocale($order->client->locale);
        
        $sourceKey = env('FIREBASE_FCM_KEY');
        $header = [
            'Authorization'=> 'key=' . $sourceKey,
            'Content-Type' => 'application/json'
        ];
        
        $body = [
            'data'=> [
                'title' => __('site.notification_title'),
                'body'  => __('site.notification_body').$order->status,
                //'image' => $data->image,
                'sound' => 'default',
            ] , 
            'notification' => [
                'title' => __('site.notification_title'),
                'body'  => __('site.notification_body').$order->status,
                //'image' => $data->image,
                'sound' => 'default',
            ],
            'content_available' => true,
            'to' => '',
        ];

        $client = new Client(['headers' => $header]);
        
        $res = $client->post('https://fcm.googleapis.com/fcm/send',[
            'body' => json_encode($body),
        ]);

        dd(json_decode($res->getBody()));
    }
    public function send_notification($order)
    {
        //set to client locale
        $devlocale = app()->getLocale();
        app()->setLocale($order->client->locale);
        
        $sourceKey = env('FIREBASE_FCM_KEY');
        $header = [
            'Authorization'=> 'key=' . $sourceKey,
            'Content-Type' => 'application/json'
        ];
        $body = [
            'data'=> [
                'title' => __('site.notification_title'),
                'body'  => __('site.notification_body').$order->status,
                'sound' => 'default',
                'content_available' => true,
            ] , 
            'notification' => [
                'title' => __('site.notification_title'),
                'body'  => __('site.notification_body').$order->status,
                'sound' => 'default',
                'content_available' => true,
            ],
            'content_available' => true,
            'to' => $order->client->fcm_token == null ? '' : $order->client->fcm_token,
        ];
        //todo : move it after send fcm request        
        $n = Notification::create([
            'title'     => __('site.notification_title'),
            'body'      => __('site.notification_body').$order->status,
            'client_id' => $order->client_id
            ]);
        //dd($n);
        //dd($body);
        $client = new Client(['headers' => $header]);
        //dd($client);
        $res = $client->post('https://fcm.googleapis.com/fcm/send',[
            'body' => json_encode($body),
        ]);
        
        //dd($res);
       //dd(json_decode($res->getBody()));
       //set to admin locale
        app()->setLocale($devlocale);
    }
}
