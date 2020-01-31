<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->boolean('is_admin')->default(false);
            $table->string('specialization')->default('Пользователь');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('admin_verified_is')->nullable();
            $table->string('password');
            $table->string('image')->default('/img/man.png');
            $table->text('about')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(array('username'));
            $table->dropUnique(array('email'));
            $table->dropPrimary('id');
            $table->dropTimestamps();
            $table->dropRememberToken();
            $table->dropColumn(
                array(
                    'id', 'name', 'username',
                    'is_admin', 'specialization',
                    'email', 'email_verified_at',
                    'admin_verified_is', 'password',
                    'image', 'about'
                    )
            );
        });
        Schema::dropIfExists('users');
    }
}
