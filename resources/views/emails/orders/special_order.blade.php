@component('mail::message')
# Special Order

{{$special_order->description}}

# Files
@foreach($special_order->files_path as $file)
    [VIEW FILE]({{$file}})
@endforeach


Thanks,<br>
{{ config('app.name') }}
@endcomponent
