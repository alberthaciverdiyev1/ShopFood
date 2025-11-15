<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        $resetUrl = url("/admin/password-reset/{$this->token}?email={$this->user->email}");

        return $this->subject('Reset Your Password')
            ->html("
                        <p>Hello {$this->user->name},</p>

                        <p>You requested a password reset. Click the link below to reset your password:</p>

                        <p><a href='{$resetUrl}'>{$resetUrl}</a></p>

                        <p>If you didn’t request this, you can safely ignore this email.</p>
                    ");
    }
}
