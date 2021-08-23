<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PurgeFilament extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('filament_password_resets');
        Schema::dropIfExists('filament_users');
    }
}
