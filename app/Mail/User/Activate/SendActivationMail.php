<?php

namespace App\Mail\User\Activate;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Activation\ActivationToken;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var ActivationToken
     */
    public $token;

    /**
     * Create a new message instance.
     *
     * @param ActivationToken $token
     */
    public function __construct(ActivationToken $token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.user.activate.mail')
                    ->subject("Please activate account.")
                    ->to("{$this->token->user->email}");
    }
}
