<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SpecialOrderMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $special_order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($special_order)
    {
        $this->special_order = $special_order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Special Order')->markdown('emails.orders.special_order');
    }
}
