<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lendings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('stuff_id');
            $table->datetime('date_time');
            $table->string('name');
            $table->uuid('user_id');
            $table->text('notes');
            $table->integer('total_stuff');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lendings');
    }
};
