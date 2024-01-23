<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            Schema::create('tasks', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->boolean('completed')->default(false);
                $table->integer('priority')->default(1);
                $table->dateTime('due_date')->nullable();
                $table->foreign('chat_id')->references('chat_id')->on('chats');
                $table->timestamps();
            });
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
