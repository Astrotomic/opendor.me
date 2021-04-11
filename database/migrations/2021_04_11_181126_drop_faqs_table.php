<?php

use App\Models\FAQ;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropFaqsTable extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists(FAQ::table());
    }
}
