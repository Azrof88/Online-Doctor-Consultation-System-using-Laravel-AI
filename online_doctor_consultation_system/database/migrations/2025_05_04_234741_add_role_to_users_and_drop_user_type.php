<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 1) Add the 'role' column if it doesn't exist
        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedTinyInteger('role')
                      ->after('password')
                      ->nullable();
            });
        }

        // 2) Migrate existing user_type values into role
        if (Schema::hasColumn('users', 'user_type')) {
            DB::table('users')->where('user_type', 'admin')  ->update(['role' => 1]);
            DB::table('users')->where('user_type', 'doctor') ->update(['role' => 2]);
            DB::table('users')->where('user_type', 'patient')->update(['role' => 3]);

            // 3) Drop the old user_type column
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('user_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down():void
    {
        // 1) Add user_type back if missing
        if (! Schema::hasColumn('users', 'user_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('user_type')
                      ->after('password')
                      ->nullable();
            });

            DB::table('users')->where('role', 1)->update(['user_type' => 'admin']);
            DB::table('users')->where('role', 2)->update(['user_type' => 'doctor']);
            DB::table('users')->where('role', 3)->update(['user_type' => 'patient']);
        }

        // 2) Drop the role column if it exists
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
