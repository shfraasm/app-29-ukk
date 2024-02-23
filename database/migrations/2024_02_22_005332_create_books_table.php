<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->string('photo');
            $table->enum('category', ['Fiksi', 'Nonfiksi']);
            $table->integer('rating_id')->nullable();
            $table->integer('total_rating')->nullable();
            $table->integer('remaining_stock');
            $table->string('author', 30);
            $table->string('publisher', 30);
            $table->year('published_year');

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
        Schema::dropIfExists('books');
    }
};
