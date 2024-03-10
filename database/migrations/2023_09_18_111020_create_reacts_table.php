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
        Schema::create('reacts', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 36)->nullable();
            $table->tinyInteger('type')->default(1)->comment('1 like, 2 love, 3 care,...');
            $table->string('reactable_id', 36)->nullable();
            $table->string('reactable_type', 36)->nullable()->comment('type: post/newfeed,media,comment,..');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reacts');
    }
};
