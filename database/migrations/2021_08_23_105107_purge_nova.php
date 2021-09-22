<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class PurgeNova extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('action_events');
    }
}
