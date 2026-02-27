<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable()->comment('ユーザーID');
            $table->string('title', 100)->nullable()->comment('商品名');
            // smallInteger から string に変更
            $table->string('category')->nullable()->comment('カテゴリー');
            $table->bigInteger('price')->default(0)->comment('値段');
            $table->smallInteger('stock')->default(0)->comment('在庫数');
            $table->string('image1', 255)->nullable()->comment('メイン画像');
            $table->string('image2', 255)->nullable()->comment('サブ画像');
            $table->string('image3', 255)->nullable()->comment('サブ画像');
            $table->string('image4', 255)->nullable()->comment('サブ画像');
            $table->string('image5', 255)->nullable()->comment('サブ画像');
            $table->string('image6', 255)->nullable()->comment('サブ画像');
            // detail から description に変更し、text型へ
            $table->text('description')->nullable()->comment('詳細');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};