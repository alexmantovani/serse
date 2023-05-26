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
        Schema::create('missing_translations', function (Blueprint $table) {
            $table->id();

            $table->string('serial_number');
            $table->string('language');
            $table->string('source');
            $table->string('context')->default('');
            $table->string('comment')->nullable();

            $table->enum('status', ['pending', 'waiting', 'translated', 'deleted'])->default('pending');

            $table->unique(['source', 'language', 'context']);

            $table->timestamp('sent_at')->nullable();
            $table->timestamp('received_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missing_translations');
    }
};
