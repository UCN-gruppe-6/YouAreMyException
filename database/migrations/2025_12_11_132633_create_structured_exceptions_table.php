<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('structured_exceptions', function (Blueprint $table) {
            $table->id();

            // Fields you requested
            $table->string('carrier');   // GLS, DFM osv.
            $table->text('message')->nullable(); // fejlbeskeder
            $table->boolean('is_deleted')->default(false); // soft delete flag

            $table->timestamps(); // created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('structured_exceptions');
    }
};