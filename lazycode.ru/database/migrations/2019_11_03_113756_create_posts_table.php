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
            $table->string('title');
            $table->string('route');
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('category_id')->index();
            $table->bigInteger('post_author_id')->index();
            $table->longText('post_body');
            $table->timestamps();
            $table
                ->foreign('post_author_id')
                ->references('id')
                ->on('users');
            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories');
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
