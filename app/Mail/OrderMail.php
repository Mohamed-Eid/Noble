<?php

namespace App\Mail;

use App\Cart;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $carts;
    public $total;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $carts, $total)
    {
        $this->order = $order;
        $this->carts = $carts;
        $this->total = $total;

        //dd($this->$order);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Order')->markdown('emails.orders.orderform');
    }
}
