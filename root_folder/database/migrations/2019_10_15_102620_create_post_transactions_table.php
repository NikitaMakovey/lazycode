<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_transactions', function (Blueprint $table) {
            $table->bigInteger('post_id');
            $table->bigInteger('username_id');
            $table->index(['post_id', 'username_id']);
            $table->boolean('vote')->nullable();
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
        Schema::dropIfExists('post_transactions');
    }
}
