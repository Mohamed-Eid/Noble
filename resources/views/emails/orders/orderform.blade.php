@component('mail::panel')

<table  style="vertical-align: top; height: 264px; width: 623px;" width="630" height="287">
   <thead>
      <tr style="height: 23px;">
         <td style="width: 199px; height: 23px;"><strong>@lang('site.index')</strong></td>
         <td style="width: 423px; height: 23px;"><strong>@lang('site.value')</strong></td>
      </tr>
   </thead>
   <tbody>
      <tr style="height: 25px;">
         <td style="min-width: 140px; width: 199px; height: 25px;"><strong>@lang('site.mobile')</strong></td>
         <td style="width: 423px; height: 25px;">{{ $order->mobile }}</td>
      </tr>
      <tr style="height: 25px;">
        <td style="min-width: 140px; width: 199px; height: 25px;"><strong>@lang('site.name')</strong></td>
        <td style="width: 423px; height: 25px;">{{ $order->client_name }}</td>
     </tr>
      <tr style="height: 35px;">
         <td style="width: 199px; height: 35px;"><strong>@lang('site.address')</strong></td>
         <td style="width: 423px; height: 35px;">
            {{ $order->client->address }}<p>&nbsp;</p>
         </td>
      </tr>
      <tr style="height: 97px;">
         <td style="width: 199px; height: 97px;"><strong>@lang('site.order')</strong></td>
         <td style="width: 423px; height: 97px;">
            @foreach ($carts as $cart)

            <table style="margin: auto; box-shadow: 3px 3px 10px #000;" border="1">
               <tbody>
                  <tr style="border-top: 2px solid #555;">
                     <td style="border: 2px dashed #555;">{{$cart->product_name}}</td>
                     <td>x{{$cart->quantity}}</td>
                  </tr>
                  <tr style="">
                     <td>@lang('site.price')</td>
                     <td>{{$cart->price}}</td>
                  </tr>
                  <tr style="">
                    <td>@lang('site.delivered_cost')</td>
                    <td>{{$order->client->district->delivered_cost}} </td>
                 </tr>
                 @foreach ($cart->details as $key => $val)

                 <tr style="">
                    <td>{{$key}}</td>
                    <td>{{$val}}</td>
                 </tr>
                 @endforeach
                </tbody>
            </table>
            <br>
            @endforeach
        </td>
      </tr>

      <tr>
         <td style="width: 199px;"><strong>@lang('site.total')</strong></td>
         <td style="width: 423px;">
            {{ $total +  $order->client->district->delivered_cost }} {{$order->client->district->city->currency}}
        </td>
      </tr>
   </tbody>
</table>
<center>
    <style>
        .button {
          border: none;
          color: white;
          padding: 15px 32px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          margin: 4px 2px;
          cursor: pointer;
        }
        
        .button1 {background-color: #4CAF50;} /* Green */
        .button2 {background-color: #008CBA;} /* Blue */
        </style>
        
    <a class="button button2" href="{{ route('dashboard.orders.show' , $order->id) }}">@lang('site.view_order')</a>
</center>

@endcomponent
