<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * todosテーブルの作成（各カラムの設定）
     * foreignId->('設定したいテーブルの単数形_id')->constrained();で外部キーに設定する（今回はusersテーブルのidということ）
     * constrained＝制約された
     * cascadeOnDelete()をつけると、そのIDを持つユーザーが削除されたとき、同時に目標も削除されるようにする
     * booleanは論理型のデータ型（真偽のtrueかfalseを指定する）
     */
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('goal_id')->constrained()->cascadeOnDelete();
            $table->boolean('done')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
