<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
        $table->decimal('amount', 10, 2);
        $table->string('method');
        $table->enum('status', ['pending','paid','failed'])->default('pending');
        $table->string('transaction_id')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('payments');
}

};
