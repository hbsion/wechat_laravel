<?php namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;
use Overtrue\Wechat\Auth;
use App;

class AuthWechat {

    public function handle($request, Closure $next)
    {

        $auth = App::make('wechat.auth');
        if (!Session::has('logged_user')) {
            $user = $auth->authorize($to = null, $scope = 'snsapi_userinfo', $state = 'STATE');
//             $auth->user();
            Session::put('logged_user', $user->openid);
        }
        return $next($request);
    }

}
