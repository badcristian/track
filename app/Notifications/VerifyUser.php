<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyUser extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly string $code)
    {
        $this->afterCommit();
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Login code: ' . $this->code)
            ->markdown('mail.login-code', ['token' => $this->code]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
