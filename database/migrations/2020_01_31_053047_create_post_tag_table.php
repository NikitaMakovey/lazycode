<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->index();
            $table->bigInteger('tag_id')->index();
            $table->unique(array('post_id', 'tag_id'));
            $table
                ->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('CASCADE');
            $table
                ->foreign('tag_id')
                ->references('id')
                ->on('tags')
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
        Schema::table('post_tag', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->dropForeign(array('post_id'));
            $table->dropIndex(array('post_id'));
            $table->dropForeign(array('tag_id'));
            $table->dropIndex(array('tag_id'));
            $table->dropUnique(array('post_id', 'tag_id'));
            $table->dropColumn(array('id', 'post_id', 'tag_id'));
        });
        Schema::dropIfExists('post_tag');
    }
}
