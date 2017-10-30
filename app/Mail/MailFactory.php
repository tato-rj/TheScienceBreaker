<?php

namespace App\Mail;

use Mail;
use Illuminate\Http\Request;
use App\Mail\BreakerNewBreak;
use App\Mail\EditorNewBreak;
use App\Mail\Welcome;
use App\Mail\Contact\BreakInquiry;
use App\Mail\Contact\Question;
use App\Mail\Contact\Submit;
use App\Mail\Contact\ContactFeedback;
use App\Manager;
use App\Author;
use App\Article;

class MailFactory
{
    public static function sendWelcomeEmail(Author $breaker)
    {
        Mail::to($breaker->email)->send(new Welcome($breaker));
    }

    public static function sendNotificationsTo($authors, $editor_id, Article $break)
    {
        $editor = Manager::find($editor_id);

        foreach ($authors as $author) {
            $breaker = Author::find($author);
            Mail::to($breaker->email)->send(new BreakerNewBreak($breaker, $break));
        }

        Mail::to($editor->email)->send(new EditorNewBreak($editor, $break));
    }

    // Contact Page

    public static function question(Request $request)
    {
        $message = [
            'subject' => 'Your message to TheScienceBreaker',
            'body' => 'Thank you for your contact! We have received your message and will get back to you shortly.'
        ];
        Mail::to($request->email)->send(new ContactFeedback($request, $message));
        Mail::to(config('app.email'))->send(new Question($request));
    }

    public static function breakInquiry(Request $request)
    {
        $message = [
            'subject' => 'Your Break inquiry',
            'body' => 'We have received your Break inquiry. We will get back to you shortly!'
        ];

        Mail::to($request->email)->send(new ContactFeedback($request, $message));
        Mail::to(config('app.email'))->send(new BreakInquiry($request));
    }

    public static function submit(Request $request)
    {
        $message = [
            'subject' => 'Your Break has been submitted!',
            'body' => 'Thank you for submitting your Break! We will review your article and you will be notified once the Break is published.'
        ];

        $file = $request->file('break')->storeAs('breaks', "$request->institution_email.doc", 'public');
        Mail::to($request->institution_email)->send(new ContactFeedback($request, $message));
        Mail::to(config('app.email'))->send(new Submit($request, $file));
    }
}