<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMailBuilder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(env('MAIL_USERNAME'))
            ->subject('Смена пароля Lazycode аккаунта')
            ->view('mail.reset.password')
            ->text('mail.reset.password.text')
            ->with('data', $this->data);
    }
}
