<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImagesToInstagramMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instagram_media', function (Blueprint $table) {
            $table->string('low_res')->after('tags');
            $table->string('high_res')->after('low_res');
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
            $table->dropColumn('low_res');
            $table->dropColumn('high_res');
        });
    }
}
