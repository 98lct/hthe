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
        Schema::create('user_pages', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 36)->nullable();
            $table->string('page_id', 36)->nullable()->comment('là page_id này để biết là user_id đã liked những page nào');
            $table->tinyInteger('notification')->default(0)->comment('0: normal, 1: turn on 2:turn off');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pages');
    }
};
