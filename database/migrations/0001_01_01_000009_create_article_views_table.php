<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->string('url'); // Сохранение URL статьи
            $table->timestamps(); // Для хранения даты и времени просмотров
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_views');
    }
};
