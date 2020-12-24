@extends('web.layouts.app')

@section('body_class')
category
@endsection

@section('title')
{{$category->name}}
@endsection

@section('header')
@include('web.layouts._custom_header',['title'=>$category->name])
@endsection

@section('content')
<div class="row">
    @include('web.categories._cats')
    <div class="categores-products">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    @include('web.categories.products')
                </div>
                <div class="col-sm-4">
                    @include('web.categories._most_ordered')
                </div>        
            </div>
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

