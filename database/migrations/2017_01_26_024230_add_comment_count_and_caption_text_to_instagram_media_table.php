<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentCountAndCaptionTextToInstagramMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instagram_media', function (Blueprint $table) {
            $table->integer('comment_count')->unsigned()->after('likes');
            $table->string('caption_text')->after('comment_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instagram_media', function (Blueprint $table) {
            $table->dropColumn('comment_count');
            $table->dropColumn('caption_text');
        });
    }
}
