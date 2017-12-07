<?php

namespace App\Http\Middleware;

use Closure, Session;

class Localization
{
    /**
     * The availables languages.
     *
     * @array $languages
     */
    protected $languages = ['en','fr'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('lang')) {
            Session::put('lang', 'en');
        }
        app()->setLocale(Session::get('lang'));
        return $next($request);
    }
}
