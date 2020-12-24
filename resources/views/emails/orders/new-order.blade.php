@component('mail::message')
# New Order

New Order has been submitted

@component('mail::button', ['url' => route('dashboard.orders.show' , $order->id) ])
    View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
