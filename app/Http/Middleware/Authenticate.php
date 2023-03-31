<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        /*if (! $request->expectsJson()) {
            return route('login');
        }*/

        $login = null;
        if (! $request->expectsJson()) {
            if(empty($request->get("account"))){
                $login = 'homepage';
            }else{
                $login = ['login'=>$request->get('account')];
            }

        }
        return route($login);
    }
}
