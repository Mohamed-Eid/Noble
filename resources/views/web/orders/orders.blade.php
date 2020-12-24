@extends('web.layouts.app')

@section('body_class')
oders-page
@endsection

@section('header')
@include('web.layouts._custom_header',['title'=>__('site.my_orders')])
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="order-boxs">
            @foreach ($orders as $order)
            <a href="{{ route('web.get_order',$order->id) }}" class="order-box">
                <div class="content">
                    <div class="order-data">
                        <h3>طلب رقم {{$order->id}}</h3>
                        <p>تاريخ الطلب: {{$order->created_at->diffForHumans()}}  </p>
                    </div>
                    <div class="order-cost">
                        <span class="btn-yellow">{{$order->total_price}} SR</span>
                    </div>
                </div>
                <div class="request-steps">
                    <div class="request-step request-step-1 active">
                        <img src="{{asset('web/images/11.png')}}" />
                        <p>جاهزة للشحن</p>
                    </div>
                    <div class="request-step request-step-2">
                        @if ($order->status_id >= 2)
                        <img src="{{asset('web/images/22.png')}}" />
                        @else
                        <img src="{{asset('web/images/2.png')}}" />
                        @endif
                        <p>قيد التوصيل</p>
                    </div>
                    @if ($order->status_id == 3)
                    <div class="request-step request-step-3 active"><img src="{{asset('web/images/s7h.png')}}" /></div>
                    @else
                    <div class="request-step request-step-3"><img src="{{asset('web/images/s77h.png')}}" /></div>
                    @endif
                </div>
            </a>                
            @endforeach

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.sub-nav-menu').on('click', function () {
            $('.sub-nav-content').toggleClass('is-active');
            $('.sub-nav-menu').toggleClass('is-active');
            $('.home-page').toggleClass('nav-is-active');
            $('.nav-overlay').toggleClass('is-active');
            toggleBodyScroll();
        });
        $('.nav-overlay').on('click', function () {
            $('.sub-nav-content').toggleClass('is-active');
            $('.sub-nav-menu').toggleClass('is-active');
            $('.home-page').toggleClass('nav-is-active');
            $('.nav-overlay').toggleClass('is-active');
            toggleBodyScroll(false);
        });
        $('.link-icon-menu').on('click', function () {
            $('.sub-nav-content').toggleClass('is-active');
            $('.sub-nav-menu').toggleClass('is-active');
            $('.home-page').toggleClass('nav-is-active');
            $('.nav-overlay').toggleClass('is-active');
            toggleBodyScroll(false);
        });
    });
    </script>
    <script>
    function goBack() {
      window.history.back();
    }
    </script> 
@endsection