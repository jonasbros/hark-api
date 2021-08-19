<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('artist_id')->unsigned();
            $table->string('title', 72);
            $table->longText('body');
            $table->string('upload_url', 512);
            $table->string('featured_image', 512);
            $table->string('hashtags', 128);
            $table->string('post_type', 32);
            $table->timestamps();
        });

        Schema::table('artist_posts', function(Blueprint $table) {
            $table->foreign('artist_id')
                  ->references('id')
                  ->on('artists')
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
        Schema::dropIfExists('artist_posts');
    }
}
