<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_feed_queues', function (Blueprint $table) 
        {
            $table->id();
            $table->string('title');
            $table->text('post');
            $table->string('image')->nullable();
            $table->string('url');
            $table->unsignedInteger('category_id');
            $table->string('feed_uuid')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_feed_queue');
    }
}
