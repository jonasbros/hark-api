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
            $table->id();
            $table->string('display_name')->length(255);
            $table->string('name', 255);
            $table->string('email')->length(255)->unique();
            $table->string('bio', 512)->nullable();
            $table->string('websites', 1024)->nullable();
            $table->string('profile_picture', 512)->nullable();
            $table->string('cover_picture', 512)->nullable();
            $table->string('password', 62)->nullable();    
            $table->string('user_type', 32); 
            $table->string('custom_url', 100)->unique();    
            $table->date('birthdate')->nullable();
            $table->timestamp('last_login');
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
        Schema::dropIfExists('users');
    }
}
