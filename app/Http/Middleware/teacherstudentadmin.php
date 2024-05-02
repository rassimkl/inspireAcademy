<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class teacherstudentadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && (auth()->user()->user_type_id !== 1 && auth()->user()->user_type_id !== 2 && auth()->user()->user_type_id !== 3)) {
            switch (auth()->user()->user_type_id) {
                case 1:
                    return redirect()->route('home');

                case 2:
                    return redirect()->route('teacher/home');

                case 3:
                    return redirect()->route('student/home');

                default:
                    return redirect('');

            }
        }
        return $next($request);
    }
}
