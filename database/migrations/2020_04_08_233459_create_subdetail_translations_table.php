<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubdetailTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subdetail_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subdetail_id')->unsigned();
            $table->string('name');
            $table->string('locale')->index();

            $table->unique(['subdetail_id','locale']);
            $table->foreign('subdetail_id')->references('id')->on('subdetails')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subdetail_translations');
    }
}
