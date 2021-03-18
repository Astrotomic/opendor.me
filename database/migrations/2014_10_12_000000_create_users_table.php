<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create(User::table(), static function (Blueprint $table): void {
            $table->bigInteger('id')->unsigned()->primary();
            $table->string('name')->unique()->index();
            $table->string('full_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('github_access_token')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->string('block_reason')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(User::table());
    }
}
