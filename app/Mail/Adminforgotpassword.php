<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Adminforgotpassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $adminname;
    public function __construct($user,$adminname)
    {
        $this->user = $user;
        $this->adminname = $adminname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Forgot Password')
                    ->view('email.forgotPassword')->with(
                        ['otpdata' => $this->user,'adminname'=>$this->adminname]);
    }
}
