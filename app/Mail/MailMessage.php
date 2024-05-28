<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public string $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $code, string $pass)
    {
        $this->msg = 'code: ' . $code . ' password: ' . $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Confirm registration code')
            ->view('emails.message')
            ->with('msg', $this->msg);
    }

}
