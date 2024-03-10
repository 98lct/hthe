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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('post_id', 36)->unique()->nullable();
            $table->string('user_id', 36)->nullable()->comment('người tạo ra nó nè');
            $table->longText('content')->nullable();
            $table->string('shared_by')->nullable()->comment('post shared: bài viết có phải là bài viết share hay ko, nếu có thì hiện thị dạng khác có nguồn chủ post gốc như facebook');
            $table->string('tag_id')->nullable()->comment('sau này mở rộng ra cho chọn ID từ table');
            $table->string('activity')->nullable()->comment('sau này mở rộng ra cho chọn ID từ table');
            $table->string('feeling')->nullable()->comment('sau này mở rộng ra cho chọn ID từ table');
            $table->json('history')->nullable()->comment('sau này mở rộng ra cho chọn ID từ table');
            $table->string('postable_id', 36)->nullable()->nullable()->comment('lấy id dựa trên models trường postable_type, nếu null thì nó lấy từ của user');
            $table->string('postable_type', 36)->nullable()->comment('type: group,page,... ex: App\Models\Group nếu null thì nó lấy từ user');
            $table->string('theme_id', 36)->nullable()->comment('này là backgroud cho text, lấy từ bảng them có setup style chữ, màu nền, màu chữ,...');;
            $table->tinyInteger('disabled')->default(0)->comment('0: on, 1: 0ff tắt mở chức năng bình luận');
            $table->tinyInteger('status')->default(0)->comment('0: public, 1: proctected - friends, 2: private: trạng thái bài viết');
            $table->boolean('is_delete')->default(0)->comment('0: show, 1: trash: xóa hay không xóa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
