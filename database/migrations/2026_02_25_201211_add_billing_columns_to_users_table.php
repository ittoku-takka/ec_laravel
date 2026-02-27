<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('billing_name')->nullable();
            // 郵便番号と電話番号を string に変更
            $table->string('billing_post_code')->nullable();
            $table->string('billing_address1')->nullable();
            $table->string('billing_address2')->nullable();
            $table->string('billing_tel')->nullable();

            $table->smallInteger('role')->default(0);
            $table->smallInteger('delete_flg')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'billing_name',
                'billing_post_code',
                'billing_address1',
                'billing_address2',
                'billing_tel',
                'role',
                'delete_flg',
            ]);
        });
    }
};
