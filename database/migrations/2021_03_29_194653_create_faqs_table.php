<?php

use App\Models\FAQ;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    public function up(): void
    {
        Schema::create(FAQ::table(), static function (Blueprint $table): void {
            $table->id();
            $table->integer('priority')->unsigned();
            $table->string('question');
            $table->text('answer');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(FAQ::table());
    }
}
