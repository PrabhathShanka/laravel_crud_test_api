<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BlogCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $blogData;

    public function __construct($blogData)
    {
        $this->blogData = $blogData;
    }

    public function build()
    {
        return $this->subject('Your blog has been published!')
                    ->view('emails.blog_created');
    }
}
