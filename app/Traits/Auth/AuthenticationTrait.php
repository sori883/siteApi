<?php

namespace App\Traits\Auth;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\LoginRequest;

trait AuthenticationTrait
{
    /**
     * get guard
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    protected function getGuard()
    {
        return Auth::guard(config('auth.defaults.guard'));
    }

    /**
     * Get the needed authorization credentials from the request.
     * 認証に使うパラメータを取得
     *
     * @param  Request $request
     * @return Array
     */
    protected function credentials(string $email, string $password)
    {
        return [
            'email' => $email,
            'password' => $password,
        ];
    }

    /**
     * Attempt to log the user into the application.
     * ログインさせる
     *
     * @param  Request $request
     * @return bool
     */
    protected function attemptLogin(string $email, string $password, bool $remember)
    {
        return $this->getGuard()->attempt(
            $this->credentials($email, $password),
            $remember
        );
    }

    /**
     * password hash
     * パスワードのhash
     *
     * @param string $password
     * @return string
     */
    protected function passwordHash($password)
    {
        return Hash::make($password);
    }

    /**
     * create activation token
     * トークンを作成する
     * @return string
     */
    protected function createToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    /**
     * Determine if the token has expired.
     *
     * @param string $createdAt
     * @return bool
     */
    protected function tokenExpired($expires, $createdAt)
    {
        return Carbon::parse($createdAt)
            ->addSeconds($expires)
            ->isPast();
    }

    /**
     * alreadyLogin
     *
     * @param string|null $message
     * @return void
     *
     * @throws HttpException
     */
    protected function alreadyLogin(string $message = null)
    {
        // set message
        $message = is_null($message) ? 'Already logged in.' : $message;

        // already logged in
        if (auth()->check()) {
            throw new HttpException(403, trans($message));
        }
    }

    /**
     * validateReset
     *
     * @param  Request $request
     * @return void
     */
    protected function validateReset(Request $request)
    {
        $request->validate([
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
    }

    /**
     * responseSuccess
     * 成功のレスポンス
     *
     * @param string $message
     * @param array $additions
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseSuccess(string $message, array $additions = [])
    {
        return response()->json(array_merge(['message' => trans($message)], $additions), 200);
    }

    /**
     * responseFailed
     * 失敗のレスポンス
     *
     * @param string $message
     * @param array $additions
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseFailed(string $message)
    {
        return response()->json(['message' => trans($message)], 403);
    }

    /**
     * responseInvalid
     * インヴァリッドのレスポンス
     *
     * @param string $message
     * @param array $errors array in array
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseInvalid(string $message, array $errors = [])
    {
        foreach ($errors as &$error) {
            foreach ($error as &$value) {
                $value = trans($value);
            }
        }

        return response()->json([
            'message' => trans($message),
            'errors' => $errors,
        ], 422);
    }
}
