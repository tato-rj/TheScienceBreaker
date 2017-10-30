<?php

namespace App\Mail\Contact;

use App\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Submit extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $breaker;
    public $file;

    public function __construct($request, $file)
    {
        $this->request = $request;
        $this->file = $file;
        $this->breaker = Author::where('email', $request->email)->get();
    }

    public function build()
    {
        return $this->markdown('emails/contact/submit')->subject('New Break Submission');
    }
}
