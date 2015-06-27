<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Overtrue\Wechat\Server;
use Overtrue\Wechat\Auth;
use Log;

class AuthController extends Controller {

    public function index(Auth $auth)
    {
        if (empty($_SESSION['logged_user'])) {
            $auth->authorize($to = null, $scope = 'snsapi_userinfo', $state = 'STATE');
            $user = $auth->user();
            Session::put('logged_user', $user->openid);
            // 跳转到其它授权才能访问的页面
        }
    }

}
