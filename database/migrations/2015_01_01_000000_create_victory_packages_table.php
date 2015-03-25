<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVictoryPackagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('victory_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 40);
            $table->string('version', 10);
            $table->string('source');
            $table->timestamp('released_at');
            $table->timestamps();

            $table->unique(['name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('victory_packages');
    }
}
