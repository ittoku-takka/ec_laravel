<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * バリデーション（入力チェック）
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'billing_name' => ['required', 'string', 'max:255'],
            'billing_post_code' => ['required', 'string', 'max:7'],
            'billing_address1' => ['required', 'string', 'max:255'],
            'billing_address2' => ['required', 'string', 'max:255'],
            'billing_tel' => ['required', 'string', 'max:15'],
            // ★roleのチェックを追加（0か1のみ許可）
            'role' => ['nullable', 'integer', 'in:0,1'],
        ]);
    }

    /**
     * ユーザー作成処理
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'billing_name' => $data['billing_name'],
            'billing_post_code' => $data['billing_post_code'],
            'billing_address1' => $data['billing_address1'],
            'billing_address2' => $data['billing_address2'],
            'billing_tel' => $data['billing_tel'],
            // ★roleを固定値(0)ではなく、画面からの入力値にする（空なら0にする）
            'role' => $data['role'] ?? 0,
            'delete_flg' => 0,
        ]);
    }
}