<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
        $table->foreignId('user_id')
              ->constrained()   // assumes users.id → doctors.user_id
              ->onDelete('cascade')
              ->onUpdate('cascade');
            //table name  will be comde from users table
        $table->string('name');
        $table->string('specialization')->nullable();
        $table->decimal('fee', 8, 2)
                  ->default(0);
        $table->string('zoom_link')->nullable();
        $table->text('bio')->nullable();
        $table->text('availability_schedule')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
