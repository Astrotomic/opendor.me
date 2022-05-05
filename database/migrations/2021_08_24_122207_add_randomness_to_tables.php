<?php

use App\Models\Organization;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([User::class, Organization::class, Repository::class] as $model) {
            DB::statement(sprintf('ALTER TABLE %s ADD COLUMN randomness point NOT NULL DEFAULT point(random(), random())', $model::table()));
            DB::statement(sprintf('CREATE INDEX %s_randomness on %s using spgist(randomness)', $model::table(), $model::table()));
        }
    }

    public function down(): void
    {
        Schema::table(User::table(), static function (Blueprint $table): void {
            $table->dropColumn('randomness');
        });
        Schema::table(Organization::table(), static function (Blueprint $table): void {
            $table->dropColumn('randomness');
        });
        Schema::table(Repository::table(), static function (Blueprint $table): void {
            $table->dropColumn('randomness');
        });
    }
};
