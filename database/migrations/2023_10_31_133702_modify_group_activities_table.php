<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class ModifyGroupActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::table('group_activities', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->after('id');
            $table->unsignedBigInteger('activity_id')->after('group_id');
            
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     
    public function down()
    {
        Schema::table('group_activities', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['activity_id']);
            
            $table->dropColumn('group_id');
            $table->dropColumn('activity_id');
        });
    }
};
