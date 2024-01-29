<?php

namespace App\Listeners;


use App\Notifications\VerifyUser;

class SendLoginCode
{
    public function __construct()
    {}

    public function handle(object $event): void
    {
        if ($event->user->hasVerifiedEmail()) {
            $event->user->notify(new VerifyUser($event->code));
        }
    }
}
