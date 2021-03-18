<?php

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationUserTable extends Migration
{
    public function up(): void
    {
        Schema::create('organization_user', static function (Blueprint $table): void {
            $table->foreignId('organization_id')->constrained(Organization::table());
            $table->foreignId('user_id')->constrained(User::table());
            $table->unique(['organization_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_user');
    }
}
