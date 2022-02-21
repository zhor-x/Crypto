<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('author')->nullable();
            $table->string('title')->index();
            $table->string('theme');
            $table->text('description');
            $table->string('image');
            $table->date('published');
            $table->text('content')->nullable();
            $table->string('url')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->foreign('source_id')->references('id')->on('content_sources')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('contents');
    }
}
