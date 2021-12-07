<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Auth\AuthenticationTrait;

class VerifyController extends Controller
{
    use AuthenticationTrait;

    /**
     * Complete registration
     * 登録を完了させる
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $this->alreadyLogin();

        $registerUser = $this->getRegisterUser($request->token);

        if (!$registerUser) {
            return $this->responseFailed('register not found.');
        }

        $user = $this->createUser($registerUser->toArray());

        event(new Registered($user));

        auth()->loginUsingId($user->id, true);

        return $this->responseSuccess('Logged in.', [
            'user' => $request->user()
        ]);
    }

    /**
     * getRegisterUser
     *
     * @param mixed $token
     * @return RegisterUser
     */
    private function getRegisterUser($token)
    {
        $registerUser = RegisterUser::where('token', $token)->first();

        if ($registerUser) {
            RegisterUser::destroy($registerUser->email);
        }

        return $registerUser;
    }

    /**
     * createUser
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function createUser(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_verified_at' => now(),
            'password' => $data['password'],
        ]);

        return $user;
    }
}
