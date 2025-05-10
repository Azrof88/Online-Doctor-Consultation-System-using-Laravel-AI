<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('symptom_check_diseases', function (Blueprint $table) {
        $table->foreignId('symptom_check_id')->constrained('symptom_checks')->cascadeOnDelete();
        $table->foreignId('disease_id')->constrained('diseases')->cascadeOnDelete();
        $table->primary(['symptom_check_id','disease_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('symptom_checks');
    }
};
