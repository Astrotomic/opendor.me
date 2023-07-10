<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::table(User::table(), static function (Blueprint $table): void {
            $table->jsonb('emails')->default('[]');
        });
    }

    public function down(): void
    {
        Schema::table(User::table(), static function (Blueprint $table): void {
            $table->dropColumn('emails');
        });
    }
};
