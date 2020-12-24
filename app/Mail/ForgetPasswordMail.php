<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $active_code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($active_code)
    {
        $this->active_code = $active_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Forget Password')->markdown('emails.clients.forget-password-code');
    }
}
