<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('title', 72)->nullable();
            $table->longText('body');
            $table->string('upload_url', 512)->nullable();
            $table->string('featured_image', 512)->nullable();
            $table->string('hashtags', 128)->nullable();
            $table->string('post_type', 32)->default('base');
            $table->timestamps();
        });

        Schema::table('user_posts', function(Blueprint $table) {
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
        Schema::dropIfExists('user_posts');
    }
}
