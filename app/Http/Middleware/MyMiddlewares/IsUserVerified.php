<?php

namespace App\Http\Middleware\MyMiddlewares;

use App\Models\User;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUserVerified
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $email_verified_at = User::where('email', $request->email)->firstOrFail()->email_verified_at;

            if ($email_verified_at === null)
                return $this->failed('you must verify your email', 401);
            else
                return $next($request);

        }catch (\Exception $e){
            return $this->failed('Unable to login: bad credentials',422);
        }
    }
}
