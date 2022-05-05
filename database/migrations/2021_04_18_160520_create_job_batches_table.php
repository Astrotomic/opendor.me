<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('job_batches', static function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('total_jobs')->unsigned();
            $table->integer('pending_jobs')->unsigned();
            $table->integer('failed_jobs')->unsigned();
            $table->json('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('created_at')->unsigned();
            $table->integer('finished_at')->unsigned()->nullable();
            $table->integer('cancelled_at')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_batches');
    }
};
