<?php

use App\Models\Repository;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoryUserTable extends Migration
{
    public function up(): void
    {
        Schema::create('repository_user', static function (Blueprint $table): void {
            $table->foreignId('repository_id')->constrained(Repository::table());
            $table->foreignId('user_id')->constrained(User::table());
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repository_user');
    }
}
