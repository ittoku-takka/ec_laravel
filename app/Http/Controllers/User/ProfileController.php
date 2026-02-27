<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * プロフィール編集画面（住所入力画面）を表示する
     */
    public function edit()
    {
        // resources/views/profile/edit.blade.php を表示
        return view('profile.edit');
    }

    /**
     * 入力された住所をデータベースに保存する
     */
    public function update(Request $request)
    {
        // 1. 今ログインしている自分自身の情報を取得
        $user = User::findOrFail(Auth::id());

        // 2. 画面から送られてきたデータを、データベースの各カラム（箱）に入れる
        $user->billing_name = $request->billing_name;
        $user->billing_post_code = $request->billing_post_code;
        $user->billing_address1 = $request->billing_address1;
        $user->billing_address2 = $request->billing_address2;
        $user->billing_tel = $request->billing_tel;

        // 3. 保存実行！
        $user->save();

        // 4. 保存が終わったら、ショッピングカート画面へ戻る
        return redirect()->route('cart')->with('success', 'お届け先を登録しました。');
    }
}