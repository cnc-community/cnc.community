<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesCategoryTable extends Migration
{
    

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('page_category', function (Blueprint $table) 
        {
            $table->id();
            $table->string("title");
            $table->string("description");
            $table->string("slug");
            $table->unsignedInteger("template_id")->nullable();
            $table->unsignedInteger("news_category_id")->nullable();
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
        Schema::connection('mysql')->dropIfExists('page_category');
    }
}
