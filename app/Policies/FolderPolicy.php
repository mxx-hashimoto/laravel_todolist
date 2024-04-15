<?php

namespace App\Policies;

use App\Folder;
use App\User;

// ★ポリシークラスでは認可処理を、真偽値を返すメソッドで表現
class FolderPolicy {
    /**
     * フォルダの閲覧権限
     * @param User $user
     * @param Folder $folder
     * @return bool
     */
    public function view(User $user, Folder $folder) {
        // ユーザーとフォルダが紐づいているときのみ許可する
        return $user->id === $folder->user_id;
    }
}
