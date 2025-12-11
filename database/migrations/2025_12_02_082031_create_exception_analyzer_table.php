<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Intentionally left blank.
        // We already have an 'exceptions' table in this project,
        // so this migration should not create or modify it.


        // If the 'exceptions' table already exists, SKIP this migration.
//        if (Schema::hasTable('exceptions')) {
//            return;
//        }
//
//        Schema::create('exceptions', function (Blueprint $table) {
//            $table->id();
//            $table->text('message')->comment('Error message of the exception');
//            $table->string('type')->comment('Type of exception, e.g., ErrorException, ModelNotFoundException');
//            $table->string('code')->comment('Error code associated with the exception');
//            $table->string('file')->comment('File where the exception occurred');
//            $table->integer('line')->comment('Line number where the exception occurred');
//            $table->string('url')->nullable()->comment('URL where the exception occurred');
//            $table->string('hostname')->comment('Server hostname');
//            $table->text('stack_trace')->comment('Full stack trace');
//            $table->integer('user_id')->nullable()->comment('User ID affected');
//            $table->string('user_email')->nullable()->comment('User email');
//            $table->string('session_id')->nullable()->comment('Session ID');
//            $table->string('level')->comment('Severity level e.g., error, warning');
//            $table->timestamp('created_at', 2);
//        });
    }

    public function down(): void
    {
        // DO NOT DROP the table — keep data safe.
        // Leave empty on purpose.
    }
};
