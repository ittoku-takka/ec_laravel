<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    // ユーザー一覧を表示
    public function index()
    {
        // roleが0（一般）の人だけを表示
        $users = User::where('role', 0)
            ->where('delete_flg', 0)
            ->orderBy('id', 'asc')
            ->get();

        return view('user.user_list', compact('users'));
    }

    // ★ 修正箇所：既存の profile.blade.php を使うように整理
    public function edit($id)
    {
        // 編集したいユーザーをIDで探す
        $user = User::findOrFail($id);

        // さっき見せてくれた「プロフィール編集画面」を表示
        // ファイル名が profile.blade.php なら 'user.profile' 
        // もし user_edit.blade.php という名前に変えたなら 'user.user_edit' にしてね
        return view('user.user_edit', compact('user'));
    }

    // ★ 更新処理
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // 設計図（Migration）にある全項目を更新できるようにします
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'billing_post_code' => $request->billing_post_code,
            'billing_tel' => $request->billing_tel,
            'billing_address1' => $request->billing_address1,
            'billing_address2' => $request->billing_address2,
            'role' => $request->role ?? $user->role, // ロール変更があれば更新
        ]);

        return redirect()->route('user_list')->with('success', 'ユーザー情報を更新しました！');
    }
}