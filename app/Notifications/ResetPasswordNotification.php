<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    use Queueable;

   /**
 * The password reset token.
 *
 * @var string
 */
public $token;
public $user;
public $url;

/**
 * Create a new notification instance.
 *
 * @return void
 */
public function __construct($token, $user)
{
    $this->token = $token;
    $this->user = $user;
    $this->url = sprintf(
        '%s/reset-password/%s?email=%s',
        request()->getSchemeAndHttpHost(),
        $token,
        $user->email,
    );
}

/**
 * Get the notification's delivery channels.
 *
 * @param  mixed  $notifiable
 * @return array
 */
public function via($notifiable)
{
    return ['mail'];
}

/**
 * Build the mail representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return \Illuminate\Notifications\Messages\MailMessage
 */
public function toMail($notifiable)
{

    $this->user->url = $this->url;
    return (new MailMessage)
        //->greeting('Hello '. $this->user?->full_name . ",")
        ->subject(Lang::get('Reset Password Notification'))
        ->view('email.forgotPassword',['post'=>$this->user]);
       // ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
      //  ->action(Lang::get('Reset Password'), $this->url)
       // ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
       // ->line(Lang::get('If you did not request a password reset, no further action is required.'));
}
}
