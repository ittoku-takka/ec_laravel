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
        Schema::create('buy_histories', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->unsignedBigInteger('user_id')->comment('購入者のユーザーID');
            $table->unsignedBigInteger('item_id')->comment('商品ID');
            $table->bigInteger('buy_number')->comment('購入番号');
            $table->smallInteger('quantity')->default(0)->comment('購入数');

            $table->string('title', 100)->comment('商品名');
            // category を string に変更
            $table->string('category')->nullable()->comment('カテゴリー');
            $table->bigInteger('price')->default(0)->comment('値段');
            $table->string('image', 255)->nullable()->comment('メイン画像');

            $table->string('billing_name', 100)->nullable()->comment('請求先氏名');
            // bigInteger から string に変更（先頭の0を保持するため）
            $table->string('billing_post_code')->nullable()->comment('請求先郵便番号');
            $table->string('billing_address1', 255)->nullable()->comment('請求先住所');
            $table->string('billing_address2', 255)->nullable()->comment('請求先建物名');
            // bigInteger から string に変更（090等のハイフンなしも対応可）
            $table->string('billing_tel')->nullable()->comment('請求先電話番号');

            $table->smallInteger('delivery_method')->comment('配送方法');
            $table->smallInteger('payment_method')->comment('支払方法');

            $table->timestamps();

            $table->index('user_id');
            $table->index('item_id');
            $table->index('buy_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_histories');
    }
};