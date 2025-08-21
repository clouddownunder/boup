<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    public $token,$email,$user;

    public function __construct($token,$email,$user)
    {
        $this->token = $token;
        $this->email = $email;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Forgot Password')
            ->greeting('Hello '.$this->user->first_name.",")
            ->line('1234It seems like you forgot your password. If this is correct, click the link below to reset your password.')
            ->action('Change Password', url('password/reset',$this->token)."?email=".$this->email."&user_type=".$this->user->user_type)
            ->line('Note : This link will expire in 15 minutes.')
            ->line('If you did not request to change your password, then simply ignore this email.');
    }
}
