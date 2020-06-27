<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('pages', function (Blueprint $table) 
        {
            $table->id();
            $table->string("title");
            $table->string("description");
            $table->string("slug");
            $table->unsignedInteger("category_id")->nullable();
            $table->unsignedInteger("template_id")->nullable();
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
        Schema::connection('mysql')->dropIfExists('pages');
    }
}
