<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('preview_image');
            $table->text('shortDesc');
            $table->text('desc');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('article');
    }
}
