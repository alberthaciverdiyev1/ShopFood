<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $link;

    public function __construct($link) {
        $this->link = $link;
    }

    public function build() {
        return $this->subject('Account Activation')
                    ->view('emails.activate');
    }
}
