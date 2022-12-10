<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->boolean('post_verified_is')->nullable();
            $table->string('image', 300);
            $table->bigInteger('category_id')->index();
            $table->bigInteger('author_id')->index();
            $table->longText('body');
            $table->timestamps();
            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('CASCADE');
            $table
                ->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(array('category_id'));
            $table->dropForeign(array('author_id'));
            $table->dropIndex(array('category_id'));
            $table->dropIndex(array('author_id'));
            $table->dropPrimary('id');
            $table->dropColumn(array('id', 'title', 'post_verified_is', 'image', 'category_id', 'author_id', 'body'));
        });
        Schema::dropIfExists('posts');
    }
}
