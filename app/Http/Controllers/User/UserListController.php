<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserListController extends Controller
{
    /**
     * ユーザー一覧画面の表示
     */
    public function index()
    {
        // 削除フラグが立っていないユーザーを全件取得
        $users = User::where('delete_flg', 0)->get();

        // resources/views/user/user_list.blade.php を表示
        return view('user.user_list', compact('users'));
    }
}