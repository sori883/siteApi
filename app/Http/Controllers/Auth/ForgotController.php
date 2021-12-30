<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ForgotRequest;
use App\Traits\Auth\AuthenticationTrait;
use App\Models\PasswordReset;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;

class ForgotController extends Controller
{
    use AuthenticationTrait;

    /**
     * forgot
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws HttpException
     */
    public function forgot(ForgotRequest $request)
    {
        $token = $this->createToken();

        $passwordReset = $this->setPasswordReset($request, $token);
        $this->sendPasswordResetMail($passwordReset);

        return $this->responseSuccess('sent email.');
    }

    /**
     * setPasswordReset
     * 古いデータが有れば削除して新しいデータをインサート
     *
     * @param Request $request
     * @param string $token
     * @return PasswordReset
     */
    private function setPasswordReset(ForgotRequest $request, string $token)
    {
        PasswordReset::destroy($request->email);

        $passwordReset = new PasswordReset($request->all());
        $passwordReset->token = $token;
        $passwordReset->save();

        return $passwordReset;
    }

    /**
     * sendResetPasswordMail
     *
     * @param PasswordReset $passwordReset
     * @return void
     */
    private function sendPasswordResetMail(PasswordReset $passwordReset)
    {
        Mail::to($passwordReset->email)
            //->send(new PasswordResetMail($passwordReset->token));
            ->queue(new PasswordResetMail($passwordReset->token));
    }
}
