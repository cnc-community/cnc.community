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
        Schema::create('page_custom_fields', function (Blueprint $table) 
        {
            $table->id();
            $table->string("key");
            $table->string("name");
            $table->unsignedInteger("page_id");
            $table->unsignedInteger("content_id");
            $table->unsignedInteger("position");
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
        Schema::dropIfExists('page_custom_fields');
    }
}
