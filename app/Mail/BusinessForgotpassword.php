<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BusinessForgotpassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $businessname;
    public function __construct($user,$businessname)
    {
        $this->user = $user;
        $this->businessname = $businessname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Forgot Password')
                    ->view('email.businessForgotPassword')->with(
                        ['otpdata' => $this->user,'adminname'=>$this->businessname]);
    }
}
