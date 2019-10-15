<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_transactions', function (Blueprint $table) {
            $table->bigInteger('comment_id');
            $table->bigInteger('username_id');
            $table->index(['comment_id', 'username_id']);
            $table->bigInteger('comment_author_id')->index();
            $table->boolean('vote')->nullable();
            $table->timestamps();
            $table
                ->foreign('comment_id')
                ->references('id')
                ->on('comments');
            $table
                ->foreign('username_id')
                ->references('id')
                ->on('users');
            $table
                ->foreign('comment_author_id')
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
        Schema::dropIfExists('comment_transactions');
    }
}
