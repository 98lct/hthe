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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 36)->nullable();
            $table->string('page_id', 36)->nullable();
            $table->string('name')->nullable();
            $table->string('pagename')->unique()->nullable();
            $table->string('subject')->nullable();
            $table->string('profile_img')->default('default.jpg');
            $table->string('cover_img')->nullable();
            $table->boolean('status')->default(0)->comment('0: show, 1: hide');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
