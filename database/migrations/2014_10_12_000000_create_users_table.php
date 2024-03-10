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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 36)->unique()->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('other_name')->nullable();
            $table->string('username')->unique()->nullable();
            $table->char('phone')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->string('email')->unique();
            $table->tinyInteger('gender')->default(0)->comment('0: nam, 1:nữ, 3: không muốn tiếc lộ');
            $table->tinyInteger('marital_status')->default(0)->comment('0: độc thân, 1: tìm hiểu, 2: hẹn hò, 3:lập gia đình, 4: góa, 5: không muốn tiếc lộ');
            $table->string('profile_img')->default('default.jpg');
            $table->string('cover_img')->default('cover.jpg');
            $table->string('introduce', 255)->nullable();
            $table->string('live_at')->nullable();
            $table->string('birth_at')->nullable();
            $table->mediumText('learn_at')->nullable();
            $table->mediumText('work_at')->nullable();
            $table->mediumText('social_address')->nullable();
            $table->json('my_event')->nullable()->comment('sự kiện trong đời');
            $table->tinyInteger('account_type')->default(0)->comment('0: mặc định, 1:tự do, 2: liên kết bên thứ 3');
            $table->boolean('daskmode')->default(0)->comment('0: off, 1: on');
            $table->boolean('hide_react')->default(0)->comment('0: off, 1: on');
            $table->boolean('is_online')->default(0)->comment('0: online, 1: offline');
            $table->json('history')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
