<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->index();
            $table->bigInteger('author_id')->index();
            $table->text('body');
            $table->timestamp('created_at')->useCurrent();
            $table
                ->foreign('post_id')
                ->references('id')
                ->on('posts')
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
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(array('post_id'));
            $table->dropForeign(array('author_id'));
            $table->dropIndex(array('post_id'));
            $table->dropIndex(array('author_id'));
            $table->dropPrimary('id');
            $table->dropColumn(array('id', 'post_id', 'author_id', 'body', 'created_at'));
        });
        Schema::dropIfExists('comments');
    }
}
