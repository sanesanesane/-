<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::table('groups', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->after('id')->nullable(); // idカラムの後に配置
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // 外部キー制約
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
public function down()
{
    Schema::table('groups', function (Blueprint $table) {
        $table->dropForeign(['user_id']); // 外部キー制約の削除
        $table->dropColumn('user_id');   // カラムの削除
    });
}

};

