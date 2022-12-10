<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_types', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('type')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vote_types', function (Blueprint $table) {
            $table->dropUnique(array('type'));
            $table->dropPrimary('id');
            $table->dropColumn(array('id', 'type'));
        });
        Schema::dropIfExists('vote_types');
    }
}
