<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class SquadRunVerifyEmail extends Notification
{
    use Queueable;

    public function __construct(){}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification())
            ]
        );

        return (new MailMessage)
            ->subject('🏃 SquadRun - Confirme seu e-mail')
            ->view('emails.verify_email',[
                'user' => $notifiable,
                'verifyUrl' => $verifyUrl
            ]);
    }
}
