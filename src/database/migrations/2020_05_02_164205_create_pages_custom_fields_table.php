<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesCustomFieldsTable extends Migration
{
    

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('page_custom_fields', function (Blueprint $table) 
        {
            $table->id();
            $table->string("key");
            $table->string("name");
            $table->unsignedInteger("page_id")->nullable();
            $table->unsignedInteger("category_id")->nullable();
            $table->unsignedInteger("content_id")->nullable();
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
        Schema::connection('mysql')->dropIfExists('page_custom_fields');
    }
}
