<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('length')->unsigned();
            $table->integer('width')->unsigned();
            $table->integer('height')->unsigned();
            $table->integer('depth')->unsigned();
            
            $table->integer('cost')->unsigned();

            $table->integer('length_cost')->nullable();
            $table->integer('width_cost')->nullable();
            $table->integer('height_cost')->nullable();
            $table->integer('depth_cost')->nullable();


            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

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
        Schema::dropIfExists('sizes');
    }
}
