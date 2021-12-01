<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Traits\Auth\AuthenticationTrait;

class LoginController extends Controller
{
    use AuthenticationTrait;
    use ThrottlesLogins;

    // ログイン試行回数（回）
    protected $maxAttempts = 3;

    // ログインロックタイム（分）
    protected $decayMinutes = 1;

    /**
     * login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws HttpException
     */
    public function login(LoginRequest $request)
    {
        // already logged in
        $this->alreadyLogin();

        // too many login
        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            // event
            $this->fireLockoutEvent($request);

            // Lockout response
            return $this->sendLockoutResponse($request);
        }

        // check login
        if ($this->attemptLogin($request->email, $request->password, true)) {
            // regenerate token
            $request->session()->regenerate();

            // ログイン失敗をリセット
            $this->clearLoginAttempts($request);

            // success login response
            return $this->responseSuccess('Logged in.', [
                'user' => $request->user()
            ]);
        }

        // ログイン試行をカウントアップ
        $this->incrementLoginAttempts($request);

        // fail login response
        return $this->responseInvalid('invalid data.', [
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * logout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // logout
        $this->getGuard()->logout();

        // session refresh
        $request->session()->invalidate();

        // regenerate token
        $request->session()->regenerateToken();

        // success login response
        return $this->responseSuccess('Logged out.');
    }
}
