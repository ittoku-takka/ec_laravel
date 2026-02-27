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
        Schema::create('carts', function (Blueprint $table) {
            $table->id()->comment('ID'); // bigint, PK
            $table->unsignedBigInteger('user_id')->comment('購入者のユーザーID');
            $table->unsignedBigInteger('item_id')->comment('商品ID');
            $table->smallInteger('quantity')->default(0)->comment('購入数');

            $table->timestamps(); // created_at, updated_at

            // インデックスで検索高速化
            $table->index('user_id');
            $table->index('item_id');

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};