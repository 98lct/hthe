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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 36);
            $table->integer('parent_id')->nullable();
            $table->text('body');
            $table->json('history')->nullable()->comment('sau này mở rộng ra cho chọn ID từ table');
            $table->string('commentable_id', 36)->nullable();
            $table->string('commentable_type', 36)->nullable()->comment('type: post/newfeed,media,group,page,comment,..');
            $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
