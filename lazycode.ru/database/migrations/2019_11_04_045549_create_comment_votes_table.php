<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_votes', function (Blueprint $table) {
            $table->bigInteger('comment_id')->index();
            $table->bigInteger('username_id')->index();
            $table->index(['comment_id', 'username_id']);
            $table->bigInteger('vote')->default(0);
            $table->timestamps();
            $table
                ->foreign('comment_id')
                ->references('id')
                ->on('comments');
            $table
                ->foreign('username_id')
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
        Schema::dropIfExists('comment_votes');
    }
}
