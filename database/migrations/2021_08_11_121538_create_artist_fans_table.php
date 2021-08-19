<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistFansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_fans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('artist_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });
        
        Schema::table('artist_fans', function(Blueprint $table) {
            $table->foreign('artist_id')
                  ->references('id')
                  ->on('artists')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artist_fans');
    }
}
