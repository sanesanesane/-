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
    Schema::table('activities', function (Blueprint $table) {
        //$table->unsignedBigInteger('category_id');
        $table->integer('duration')->nullable();  // 分単位での勉強時間

        // 外部キー制約の設定
        //$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */

public function down()
{
    Schema::table('activities', function (Blueprint $table) {
        $table->dropForeign(['category_id']);
        $table->dropColumn(['category_id', 'duration']);
    });
}
};
