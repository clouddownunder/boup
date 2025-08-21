<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $emailUpdated;
    public function __construct($emailUpdated)
    {
        $this->emailUpdated = $emailUpdated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Address Updated Successfully')
                    ->view('email.changeEmail')->with(
                        ['userinfo' => $this->emailUpdated]);
    }
}
