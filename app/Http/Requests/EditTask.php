<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Validation\Rule;

// FormRequest(バリデーション機能)を継承したCreateTaskを継承する
class EditTask extends CreateTask {
    public function rules() {
        $rule = parent::rules();

        $status_rule = Rule::in(array_keys(Task::STATUS));

        return $rule + [
            'status' => 'required|' . $status_rule,
        ];
    }

    public function attributes() {
        $attributes = parent::attributes();

        // ★$attributesには、属性名と値が格納されている
        return $attributes + [
            'status' => '状態',
        ];
    }

    public function messages() {
        $messages = parent::messages();

        $status_labels = array_map(function($item) {
            return $item['label'];
        }, Task::STATUS);

        $status_labels = implode('、', $status_labels);

        return $messages + [
            'status.in' => ':attribute には ' . $status_labels. ' のいずれかを指定してください。',
        ];
    }
}