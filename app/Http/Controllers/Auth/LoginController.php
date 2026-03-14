<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/item_list';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // --- 管理者専用画面の表示 ---
    public function showAdminLoginForm()
    {
        return view('auth.admin_login');
    }

    // --- 管理者専用ログイン実行 ---
    public function adminLogin(Request $request)
    {
        // 1. バリデーション
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. 認証試行
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // 3. 【修正済み】メールアドレス指定をやめ、role が 1 なら全員許可する
            if ((int) $user->role === 1) {
                $request->session()->regenerate();
                return redirect()->route('item.index');
            }

            // 管理者でない場合はログアウト
            Auth::logout();
            return back()->withErrors(['email' => '管理者権限がありません。']);
        }

        // ログイン失敗
        return back()->withErrors(['email' => '認証情報が一致しません。'])->withInput();
    }

    // 通常ログイン後の振り分け（標準機能用）
    protected function authenticated(Request $request, $user)
    {
        // ここも role 判定に修正
        if ((int) $user->role === 1) {
            return redirect()->route('item.index');
        }
        return redirect()->route('item_list');
    }
}