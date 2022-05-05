<?php

use App\Models\Organization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create(Organization::table(), static function (Blueprint $table): void {
            $table->bigInteger('id')->unsigned()->primary();
            $table->string('name')->unique()->index();
            $table->timestamp('blocked_at')->nullable();
            $table->string('block_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(Organization::table());
    }
};
