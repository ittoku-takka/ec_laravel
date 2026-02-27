<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // 判定を一番甘くします。このメアドなら絶対にadminとして認めます。
        Gate::define('admin', function (User $user) {
            return $user->email === 'kanri@techis.jp' || $user->role === 'admin';
        });
    }
}