<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ★ミドルウェアを適用★
Route::group(['middleware' => 'auth'], function() {
  // ★ホームページ
  Route::get('/', 'HomeController@index')->name('home');

  // ★フォルダ追加ページを表示
  Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
  // ユーザーがフォルダ名を入力してPOST送信すると
  Route::post('/folders/create', 'FolderController@create');


  // ★ポリシーのミドルウェアを適用
  // canミドルウェア：認可処理が true を返せばそのまま後続処理に移り、false を返せば処理を中断してコード 403 でレスポンス
  Route::group(['middleware' => 'can:view,folder'], function() {
    // ★フォルダ・タスク一覧ページ
    // ルートモデルバインディングに対応するため、{id}を{folder}に書き換える
    Route::get('/folders/{folder}/tasks', 'TaskController@index')->name('tasks.index');

    // ★タスク追加ページを表示
    Route::get('/folders/{folder}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
    // ★タスク追加処理を実行
    Route::post('/folders/{folder}/tasks/create', 'TaskController@create');


    // ★タスク編集ページを表示
    Route::get('/folders/{folder}/tasks/{task}/edit', 'TaskController@showEditForm')->name('tasks.edit');
    // ★タスク編集処理を実行
    Route::post('/folders/{folder}/tasks/{task}/edit', 'TaskController@edit');
  });

});

// ★認証機能のルーティング
// 会員登録・ログイン・ログアウト・パスワード再設定の各機能で必要なルーティング設定をすべて定義
Auth::routes();
