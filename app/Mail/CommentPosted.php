<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $comment;

    // １．コンストラクタ
    public function __construct(User $user, Comment $comment)
    {
        $this->user = $user;
        $this->comment = $comment;
    }

    // ２．buildメソッド
    public function build()
    {
        return $this
            ->subject('コメントありがとうございます')
            ->view('emails.comments.posted');
    }
}

// メソッド	用途
// from	送信元のアドレスと送信名を指定する
// subject	件名を指定する
// view	本文のテンプレート名を指定する（HTML）
// text	本文のテンプレート名を指定する（テキスト）