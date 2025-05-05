<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1) Change the column type to match roles.id (unsigned BIGINT)
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role')
                  ->change();
        });

        // 2) Add the foreign‐key constraint now that the types match
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        // Remove FK then revert type back to tinyInteger if you need
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role']);
            $table->unsignedTinyInteger('role')
                  ->change();
        });
    }
};
