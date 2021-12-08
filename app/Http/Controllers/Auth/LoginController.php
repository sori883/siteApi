<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Traits\Auth\AuthenticationTrait;

class LoginController extends Controller
{
    use AuthenticationTrait;

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

        // check login
        if ($this->attemptLogin($request->email, $request->password, true)) {
            // regenerate token
            $request->session()->regenerate();

            // success login response
            return $this->responseSuccess('Logged in.', [
                'user' => $request->user()
            ]);
        }

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
