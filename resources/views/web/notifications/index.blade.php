@extends('web.layouts.app')

@section('body_class')
notifications-page
@endsection

@section('header')
@include('web.layouts._custom_header',['title'=>__('site.notifications')])
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="notifications-boxs">
            @foreach ($notifications as $notification)
            <div class="notification-box">
                <div class="data">{{$notification->created_at->diffForHumans()}}</div>
                <div class="box">
                    <div class="top">{{$notification->title}}</div>
                    <div class="image">
                        @if ($notification->image == null)
                        <img src="{{asset('web/images/logo3.png')}}" />
                        @else
                        <img src="{{$notification->image_path}}" />
                        @endif
                    </div>
                    <div class="content">
                        <p>{{$notification->body}}</p>
                    </div>
                </div>
            </div>                
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