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
            $table->bigIncrements('id');
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
                ->on('vote_types')
                ->onDelete('CASCADE');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
            $table
                ->foreign('direct_id')
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
        Schema::table('votes', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->dropForeign(array('type_id'));
            $table->dropForeign(array('user_id'));
            $table->dropForeign(array('direct_id'));
            $table->dropUnique(array('type_id', 'source_id', 'user_id'));
            $table->dropIndex(array('direct_id'));
            $table->dropTimestamps();
            $table->dropColumn(array('type_id', 'source_id', 'user_id', 'direct_id', 'vote'));
        });
        Schema::dropIfExists('votes');
    }
}
