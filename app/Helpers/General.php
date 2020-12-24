<?php

use App\City;

function count_shopping_cart_items()
{
    $count = 0;
    
    $client = find_client();
    if($client){
       $count = $client->shopping_carts->count();
    }

    return $count;
}

function find_client()
{
    return auth('client')->user();
}

function get_download_links(){
    return \App\Download::first();
}

use App\Tax;

function calc_tax_on_price($price)
{
    $tax = Tax::first()->tax;

    return ($price)*($tax/100);
}

function discount($price,$discount)
{
    return $price - $price*($discount/100);
}

function default_currency()
{
    $city = City::where('is_default',1)->first();
    return $city->currency;
}

function converted_currency($price){
    $city = City::where('is_default',1)->first();
    $default_currency = $city->value;

    $user_currency = auth('client')->user()->district->city->value ?? $default_currency;

    //dd('default_currency='.$default_currency.' || user_currency='.$user_currency);
    return (($price*$user_currency)/$default_currency);
    /**
     *  1 ras  => 4 egp
     *  10 ras => ? egp
     */
}
?>