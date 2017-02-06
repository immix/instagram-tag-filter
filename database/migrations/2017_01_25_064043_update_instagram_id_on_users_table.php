<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInstagramIdOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('instagram_id');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('instagram_id', 10)->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('instagram_id');
        });    
        
        Schema::table('users', function (Blueprint $table) {
            $table->integer('instagram_id')->unsigned()->after('id');
        });
    }
}
