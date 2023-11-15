<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comics', function (Blueprint $table){
            $table->id();
            $table->string('title',100);
            $table->string('overview', 200)->nullable();
            $table->smallInteger('comic_likes_count')->default(0);
            $table->boolean('reserved')->default(0);
            $table->date('released_at');
            $table->string('image', 120)->nullable();
            $table->timestamps();
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
