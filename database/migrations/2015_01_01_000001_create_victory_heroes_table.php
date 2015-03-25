<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVictoryHeroesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('victory_heroes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100);
            $table->char('password', 60);
            $table->timestamp('online_at');
            $table->timestamps();
            $table->rememberToken();

            $table->unique(['email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('victory_heroes');
    }
}
