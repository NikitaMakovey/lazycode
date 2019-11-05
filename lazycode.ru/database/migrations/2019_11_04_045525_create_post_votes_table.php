<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_votes', function (Blueprint $table) {
            $table->bigInteger('post_id')->index();
            $table->bigInteger('username_id')->index();
            $table->index(['post_id', 'username_id']);
            $table->bigInteger('vote')->default(0);
            $table->timestamps();
            $table
                ->foreign('post_id')
                ->references('id')
                ->on('posts');
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
        Schema::dropIfExists('post_votes');
    }
}
