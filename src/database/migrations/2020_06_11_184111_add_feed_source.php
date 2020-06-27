<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeedSource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->table('news', function (Blueprint $table) 
        {
            $table->string('feed_source')->nullable();
            $table->unsignedInteger('user_id')->nullable();
        });
        
        Schema::connection('mysql')->table('news_feed_queues', function (Blueprint $table) 
        {
            $table->string('feed_source')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
