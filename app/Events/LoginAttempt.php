<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class LoginAttempt
{
    use SerializesModels;

    public function __construct(
        public $user,
        public string $code
    ){}
}
