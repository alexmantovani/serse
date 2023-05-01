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
        Schema::create('accredits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained();

            $table->string('token')->unique();
            $table->string('customer_email');
            $table->string('customer_company')->nullable();
            $table->string('customer_id')->default('superuser');
            $table->string('customer_name')->default('Temporary Superuser');
            $table->string('pin')->default('0000');
            $table->string('machine')->default('All');
            $table->string('language')->default('it');
            $table->tinyInteger('duration')->default(5);
            $table->tinyInteger('level')->default(7);
            $table->timestamp('downloaded_at')->nullable();
            $table->string('display_type')->default('ed1');
            $table->string('format')->default('all');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accredits');
    }
};
