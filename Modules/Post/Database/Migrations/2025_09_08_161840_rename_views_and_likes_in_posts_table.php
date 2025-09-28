<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameViewsAndLikesInPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // اگر فیلدهای views و likes وجود دارند، آن‌ها را تغییر نام دهید
            if (Schema::hasColumn('posts', 'views') && !Schema::hasColumn('posts', 'views_count')) {
                $table->renameColumn('views', 'views_count');
            }
            if (Schema::hasColumn('posts', 'likes') && !Schema::hasColumn('posts', 'likes_count')) {
                $table->renameColumn('likes', 'likes_count');
            }
            
            // اگر فیلدها وجود ندارند، اضافه کنید
            if (!Schema::hasColumn('posts', 'views_count')) {
                $table->unsignedBigInteger('views_count')->default(0)->after('content');
            }
            if (!Schema::hasColumn('posts', 'likes_count')) {
                $table->unsignedBigInteger('likes_count')->default(0)->after('views_count');
            }
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'views_count')) {
                $table->renameColumn('views_count', 'views');
            }
            if (Schema::hasColumn('posts', 'likes_count')) {
                $table->renameColumn('likes_count', 'likes');
            }
        });
    }
}