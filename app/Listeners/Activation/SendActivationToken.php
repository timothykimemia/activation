<?php

namespace App\Listeners\Activation;

use App\Events\Activation\RequestActivationToken;
use App\Mail\User\Activate\SendActivationMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendActivationToken
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RequestActivationToken  $event
     * @return void
     */
    public function handle(RequestActivationToken $event)
    {
        Mail::to($event->user)->send(new SendActivationMail($event->user->activationToken));
    }
}
