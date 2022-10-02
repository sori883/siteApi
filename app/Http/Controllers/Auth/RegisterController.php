<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterUser;
use App\Http\Requests\Auth\RegisterRequest;
use App\Traits\Auth\AuthenticationTrait;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    use AuthenticationTrait;

    /**
     * Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws HttpException
     */
    public function register(RegisterRequest $request)
    {
        $this->alreadyLogin();

        $token = $this->createToken();
        $registerUser = $this->setRegisterUser($request, $token);
        $this->sendVerificationMail($registerUser);

        return $this->responseSuccess('sent email.');
    }

    /**
     * 古いデータが有れば削除して新しいデータをインサート
     *
     * @param Request $request
     * @param string $token
     * @return RegisterUser
     */
    private function setRegisterUser(RegisterRequest $request, string $token)
    {
        RegisterUser::destroy($request->email);

        $registerUser = new RegisterUser($request->all());

        $registerUser->token = $token;
        $registerUser->password = $this->passwordHash($request->password);
        $registerUser->save();

        return $registerUser;
    }

    /**
     * sendVerificationMail
     *
     * @param RegisterUser $registerUser
     * @return void
     */
    private function sendVerificationMail(RegisterUser $registerUser)
    {
        Mail::to($registerUser->email)
            ->queue(new VerificationMail($registerUser->token));
    }
}
