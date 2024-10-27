<?php

namespace App\Listeners;

use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\Log;

class SendNewUserNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        $name = $event->user->name;
        $code = $event->code;

        Log::info("Hi $name, your verification code is $code.");
    }
}
