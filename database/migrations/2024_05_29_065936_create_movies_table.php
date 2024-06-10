<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("desc", 4000);
            $table->string("realease");
            $table->string("runtime");
            $table->enum('quality', ['hd', 'fullhd','2k','4k']);
            $table->enum('type', ['movie','tvshow']);
            $table->integer("age");
            $table->string("cover")->default("nothumb.png");
            $table->string("back_photo")->default("nothumb_back.png");
            $table->string("source_link");
            $table->unsignedBigInteger("user_id");
            $table->timestamps();   

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
