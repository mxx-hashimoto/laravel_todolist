<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// バリデーション適用－１：FormRequestを継承したクラスを作成。
class CreateTask extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // titleやdue_dateは、ユーザーが入力するフォームのname属性と紐づいている
    public function rules() {
        return [
            'title' => 'required|max:100',
            'due_date' => 'required|date|after_or_equal:today',
        ];
    }

    // name属性の表示名をつけるメソッド
    public function attributes() {
        return [
            'title' => 'タイトル',
            'due_date' => '期限日',
        ];
    }

    // 事前に作成されていないバリデーションメッセージを作成するメソッド
    public function messages() {
        return [
            'due_date.after_or_equal' => ':attribute には今日以降の日付を入力してください。',
        ];
    }
}
