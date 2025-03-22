<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('comment_id')->constrained()->onDelete('cascade');
            $table->boolean('is_like'); // true = лайк, false = дизлайк
            $table->timestamps();

            $table->unique(['user_id', 'comment_id']); // Один пользователь может голосовать за комментарий только один раз
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
}