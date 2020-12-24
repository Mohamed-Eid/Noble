@extends('web.pages.layout')

@section('title')
@lang('site.complete_payment')
@endsection

    <link rel="shortcut icon" href="https://goSellJSLib.b-cdn.net/v1.4.1/imgs/tap-favicon.ico" />
    <link href="https://goSellJSLib.b-cdn.net/v1.4.1/css/gosell.css" rel="stylesheet" />


@section('content')

            <!-- Tap pay button -->
            <div id="root"></div>
            <div class="footer-button" >
                <button  id="openPage" onclick="process_order()" class="btn btn-block btn-yellow">@lang('site.complete_payment')</button>
            </div>

            {{-- <script type="text/javascript" src="{{asset('site/js/jquery.min.js')}}"></script> --}}
    <script src="{{ asset('dashboard/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="https://goSellJSLib.b-cdn.net/v1.4.1/js/gosell.js"></script>


<script>
    
    var cart_data = [];

    @foreach ($carts as $cart)
    cart_data.push({
      id: "{{$cart['product']['id']}}",
      name: "{{$cart['product']['name']}}",
      description: '',
      quantity: "{{$cart['quantity'] }}",
      amount_per_unit: "{{ $cart['price'] }}",
      });
    @endforeach    

    console.log(cart_data);
    function process_order(){
        goSell.openPaymentPage();
    }

    goSell.config({
      containerID:"root",
      gateway:{
        publicKey:"{{ env('TAP_PUBLIC_KEY') }}",
        merchantId: null,
        language:"ar",
        contactInfo:true,
        supportedCurrencies:"all",
        supportedPaymentMethods: "all",
        saveCardOption:false,
        customerCards: true,
        notifications:'standard',
        callback:(response) => {
            console.log('response', response);
        },
        onClose: () => {
            console.log("onClose Event");
        },
        backgroundImg: {
          opacity: '0.5'
        },
        labels:{
            cardNumber:"Card Number",
            expirationDate:"MM/YY",
            cvv:"CVV",
            cardHolder:"Name on Card",
            actionButton:"Pay"
        },
        style: {
            base: {
              color: '#535353',
              lineHeight: '18px',
              fontFamily: 'sans-serif',
              fontSmoothing: 'antialiased',
              fontSize: '16px',
              '::placeholder': {
                color: 'rgba(0, 0, 0, 0.26)',
                fontSize:'15px'
              }
            },
            invalid: {
              color: 'red',
              iconColor: '#fa755a '
            }
        }
      },
      customer:{
        id:null,
        first_name: "First Name",
        middle_name: "Middle Name",
        last_name: "Last Name",
        email: "demo@email.com",
        phone: {
            country_code: "965",
            number: "99999999"
        }
      },
      order:{
        amount: {{ $data['total_price'] }},
        currency:"{{ auth('client')->user()->district->city->translate('en')->currency }}",
        items: cart_data ,
        shipping:null,
        taxes: null
      },
     transaction:{
       mode: 'charge',
       charge:{
          saveCard: false,
          threeDSecure: true,
          description: "Test Description",
          statement_descriptor: "Sample",
          reference:{
            transaction: "txn_0001",
            order: "ord_0001"
          },
          metadata:{},
          receipt:{
            email: false,
            sms: true
          },
          redirect: "{{ route('web.redirect_after_payment') }}",
          post: null,
        }
     }
    });

    </script>
    
@endsection






