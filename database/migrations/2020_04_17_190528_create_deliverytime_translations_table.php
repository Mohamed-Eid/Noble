<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverytimeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverytime_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deliverytime_id')->unsigned();
            $table->string('name');
            $table->string('locale')->index();
        
            $table->unique(['deliverytime_id','locale']);
            $table->foreign('deliverytime_id')->references('id')->on('deliverytimes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliverytime_translations');
    }
}
