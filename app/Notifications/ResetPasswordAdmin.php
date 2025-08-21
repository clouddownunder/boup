<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordAdmin extends Notification
{
    use Queueable;

    public $token,$email,$user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token,$email,$user)
    {
        $this->token = $token;
        $this->email = $email;
        $this->user = $user;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $this->user->url = url('admin/password/reset',$this->token)."?email=".$this->email;
        return (new MailMessage)
        ->subject('Forgot Password')
         ->view('email.forgotPassword',['post'=>$this->user]);
            //->greeting('Hello '.$this->user->first_name.",")
            //->line('It seems like you forgot your password. If this is correct, click the link below to reset your password.')
            //->action('Change Password', url('admin/password/reset',$this->token)."?email=".$this->email)
           // ->line('Note : This link will expire in 15 minutes.')
            //->line('If you did not request to change your password, then simply ignore this email.');
    }

}
