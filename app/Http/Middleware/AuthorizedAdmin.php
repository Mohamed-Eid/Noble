<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use App\Http\Controllers\Api\ApiResponseTrait;
class AuthorizedAdmin
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = request()->header('x-api-key');
        $admin = User::where('api_token',$token)->first();
        //return $admin;
        if($admin)
        {
            request()->admin = $admin;
            return $next($request);
        }
        return $this->ApiResponse(false, [__('site.access_denied')], __('site.access_denied'), [], 401);

    }
}
