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
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->string('media_id', 36)->unique();
            $table->string('type')->default('image')->comment('image/video');
            $table->string('src')->nullable();
            $table->string('url')->nullable();
            $table->string('user_id', 36)->nullable();
            $table->string('mediable_id', 36)->nullable()->nullable()->comment('lấy id dựa trên models trường sourceable_type hoặc là newfeed_id');
            $table->string('mediable_type', 36)->nullable()->comment('type: newfeed/post,group,page,comment, album... ex: App\Models\Group');
            $table->tinyInteger('status')->default(0)->comment('0: public, 1: proctected - friends, 2: private');
            $table->boolean('is_delete')->default(0)->comment('0: show, 1: trash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medias');
    }
};
