<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\CreateTask;

use App\Http\Requests\EditTask;
use App\Task;
use Illuminate\Http\Request;
// ★ Authクラスをインポートする
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    // 引数のデータ型を指定する必要がある
    // ルートモデルバインディング→Folderクラスの$folderを受け取る
    /**
     * タスク一覧
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
    public function index(Folder $folder) {

        if (Auth::user()->id !== $folder->user_id) {
            abort(403);
        }
        // すべてのフォルダデータを取得
        // $folders = Folder::all();
        // ログインユーザーのフォルダのみ取得する
        $folders = Auth::user()->folders()->get();

        // 選ばれたフォルダを取得する
        // ★Findメソッド：プライマリキーのカラムを条件として一行分のデータを取得
        // $current_folder = Folder::find($id);

        // if (is_null($current_folder)) {
        //     // ★abort関数：引数のコードに対応するエラーページが返却される
        //     abort(404);
        // }

        // 選ばれたフォルダに紐づくタスクを取得する
        $tasks = $folder->tasks()->get();


        return view('tasks/index', [
            // key => value
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks
        ]);
    }

    /**
     * GET /folders/{id}/tasks/create
    */
    // ユーザーが入力したもの→CreateFolder $request
    // ユーザーが入力してないもの→int $id
    /**
     * タスク作成フォーム
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
    public function showCreateForm(Folder $folder) {
        return view('tasks/create', [
            'folder_id' => $folder->id
        ]);
    }

    // ★値を受け取って→バリデーションまでする
    // Requestだと、受け取るだけ。
    /**
     * タスク作成
     * @param Folder $folder
     * @param CreateTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Folder $folder, CreateTask $request) {
        // $current_folder = Folder::find($id);

        $task = new Task();
        // タイトルと期限をテーブルに紐づけ
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

    // int $id：ルーティングの{id}部分で、フォルダーに関するID
    // $task_id：ルーティングの{task_id}部分で、タスクに関するID
    /**
     * タスク編集フォーム
     * @param Folder $folder
     * @param Task $task
     * @return \Illuminate\View\View
     */
    public function showEditForm(Folder $folder, Task $task) {

        // ★find：引数の$task_idとtasksテーブルの紐づくものを抽出
        // $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    // int $id：ルーティングの{id}部分で、フォルダーに関するID
    // $task_id：ルーティングの{task_id}部分で、タスクに関するID
    // EditTask $request：ユーザーが入力したデータを受け取り、バリデーションチェックを行う
    // ★バリデーションしたいときは、FormRequestクラスを継承★
    /**
     * タスク編集
     * @param Folder $folder
     * @param Task $task
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Folder $folder, Task $task, EditTask $request) {

        // dd($id, $task_id, $request);
        // 1
        // 編集ボタンをクリックした、タスクの情報が取得される
        // $task = Task::find($task_id);

        // 2
        // 左：編集ボタンをクリックした、タスクの情報
        // 右：ユーザーが入力したデータを、tasksテーブルの各カラムに代入（保存はまだ）
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        // 代入したデータをtasksテーブルに保存する
        $task->save();

        // 3
        // データの保存が完了したら、リダイレクトをする
        // tasks > index.blade.phpへ遷移
        // その際、編集するタスクに紐づくフォルダを開いた状態にしたいので、データを渡している
        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }

    private function checkRelation(Folder $folder, Task $task) {
        if ($folder->id !== $task->folder_id) {
            abort(404);
        }
    }
}