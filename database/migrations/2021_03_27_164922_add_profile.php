<?php

use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(User::table(), static function (Blueprint $table): void {
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('twitter')->nullable();
            $table->string('website')->nullable();
        });

        Schema::table(Organization::table(), static function (Blueprint $table): void {
            $table->string('full_name')->nullable();
            $table->boolean('is_verified')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('twitter')->nullable();
            $table->string('website')->nullable();
        });

        Schema::table(Repository::table(), static function (Blueprint $table): void {
            $table->integer('stargazers_count')->default(0);
            $table->text('website')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table(User::table(), static function (Blueprint $table): void {
            $table->dropColumn('description');
            $table->dropColumn('location');
            $table->dropColumn('twitter');
            $table->dropColumn('website');
        });

        Schema::table(Organization::table(), static function (Blueprint $table): void {
            $table->dropColumn('full_name')->nullable();
            $table->dropColumn('is_verified')->nullable();
            $table->dropColumn('description')->nullable();
            $table->dropColumn('location')->nullable();
            $table->dropColumn('twitter')->nullable();
            $table->dropColumn('website')->nullable();
        });

        Schema::table(Repository::table(), static function (Blueprint $table): void {
            $table->dropColumn('stargazers_count');
            $table->dropColumn('website');
        });
    }
};
