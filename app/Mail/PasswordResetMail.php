<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected $token;
    protected $resetRoute = 'account/reset';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        // 引数でトークンを受け取る
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // 件名
        $subject = 'reset password mail';

        // VueへのコールバックURLをルート名で取得
        $baseUrl = config('app.front_url');
        $token = $this->token;
        $url = "{$baseUrl}/{$this->resetRoute}/{$token}";

        // 送信元のアドレス
        // .envの「MAIL_FROM_ADDRESS」に設定したアドレスを取得
        $from = config('mail.from.address');

        return $this
            ->from($from)
            ->subject($subject)
            // 送信メールのビュー
            ->view('mails.forgot_mail')
            // ビューで使う変数を渡す
            ->with('url', $url);
    }
}
