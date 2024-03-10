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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 36)->nullable()->comment('user đã tương tác');
            $table->string('source_id', 36)->nullable()->comment('user được tương tác');
            $table->string('title')->nullable();
            $table->tinyInteger('type')->default(0)->comment('0: like, 1: share, 2: comment, 3: change profile iamge, 4:friends_add, 5: follow, 6: new post, 7 new stort, 8 new media');
            $table->string('notifiable_id', 36)->nullable()->comment('type: user,post/newfeed,media,comment,..');
            $table->string('notifiable_type', 36)->nullable()->comment('type:user,post/newfeed,media,comment,..');
            $table->boolean('is_read')->default(0)->comment('0: unread, 1: read');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
