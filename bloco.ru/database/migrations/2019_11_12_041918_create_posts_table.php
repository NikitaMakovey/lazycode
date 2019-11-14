<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 300);
            $table->string('image')->nullable();
            $table->bigInteger('category_id')->index();
            $table->bigInteger('author_id')->index();
            $table->longText('body');
            $table->string('route')->nullable();
            $table->timestamps();
            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table
                ->foreign('author_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
