<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_genres', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('artist_id')->unsigned();
            $table->bigInteger('genre_id')->unsigned();
            $table->timestamps();
        });
        
        Schema::table('artist_genres', function(Blueprint $table) {
            $table->foreign('artist_id')
                  ->references('id')
                  ->on('artists')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('genre_id')
                  ->references('id')
                  ->on('genres')
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
        Schema::dropIfExists('artist_genres');
    }
}
