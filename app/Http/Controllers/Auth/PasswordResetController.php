<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Auth\AuthenticationTrait;
use App\Http\Requests\Auth\ResetRequest;
use App\Models\User;
use App\Models\PasswordReset;

class PasswordResetController extends Controller
{
    use AuthenticationTrait;

    /**
     * passwordReset
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws HttpException
     */
    public function reset(ResetRequest $request)
    {
        $reset = PasswordReset::where('token', $request->token)->first();

        $user = User::where('email', $reset->email)->first();
        $user->password = $this->passwordHash($request->password);
        $user->save();

        return $this->responseSuccess('password reset.');
    }
}
