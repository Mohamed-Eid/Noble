@extends('web.layouts.app')

@section('body_class')
special-page
@endsection

@section('header')
@include('web.layouts._custom_header',['title'=>__('site.special_order')])
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="special-order-boxs">
            <form action="{{ route('web.special_order.store') }}" method="POST" enctype="multipart/form-data">
                @include('partials._errors')

                @csrf
                <div class="input-file-container">  
                <input class="input-file" id="my-file" type="file" name="file">
                <label tabindex="0" for="my-file" class="input-file-trigger">@lang('site.add_file')<i class="fa fa-upload"></i></label>
              </div>
              <p class="file-return"></p>
                <div class="special-box">
                    <label for="details">@lang('site.write_notes')</label>
                    <textarea class="form-control" name="description" id="details" rows="3"></textarea>
                </div>
                <div class="special-order-button">
                    <button type="submit" class="btn btn-block btn-lg btn-yellow">@lang('site.confirm_order')</button>
                </div>
            </form>
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

<script type="text/javascript">
    document.querySelector("html").classList.add('js');
    
    var fileInput  = document.querySelector( ".input-file" ),  
        button     = document.querySelector( ".input-file-trigger" ),
        the_return = document.querySelector(".file-return");
          
    button.addEventListener( "keydown", function( event ) {  
        if ( event.keyCode == 13 || event.keyCode == 32 ) {  
            fileInput.focus();  
        }  
    });
    button.addEventListener( "click", function( event ) {
       fileInput.focus();
       return false;
    });  
    fileInput.addEventListener( "change", function( event ) {  
        the_return.innerHTML = this.value;  
    });  
    </script>
@endsection