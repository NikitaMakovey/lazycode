<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->tinyInteger('type_id');
            $table->bigInteger('source_id');
            $table->bigInteger('user_id');
            $table->bigInteger('direct_id')->index();
            $table->boolean('vote');
            $table->timestamps();
            $table->unique(['type_id', 'source_id', 'user_id']);
            $table
                ->foreign('type_id')
                ->references('id')
                ->on('vote_types');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');
            $table
                ->foreign('direct_id')
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
        Schema::dropIfExists('votes');
    }
}
