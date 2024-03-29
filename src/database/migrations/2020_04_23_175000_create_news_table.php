<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('news', function (Blueprint $table) 
        {
            $table->id();
            $table->string('title');
            $table->text('post')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->enum('type', ['internal', 'external']);
            $table->unsignedInteger('category_id');
            $table->string('feed_uuid')->unique()->nullable();
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
        Schema::connection('mysql')->dropIfExists('news');
    }
}
