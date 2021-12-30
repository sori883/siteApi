<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\VerifyRequest;
use App\Traits\Auth\AuthenticationTrait;
use App\Models\RegisterUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;

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
    public function verify(VerifyRequest $request)
    {
        $this->alreadyLogin();

        $registerUser = $this->getRegisterUser($request->token);

        if (!$registerUser) {
            return $this->responseFailed('register not found.');
        }

        $user = $this->createUser($registerUser->toArray());

        auth()->loginUsingId($user->id, $remember = true);

        return new JsonResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
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
            // RegisterUser::destroy($registerUser->email);
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
