<?php

use Catanchin\NovaNotesField\NotesFieldServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable(NotesFieldServiceProvider::getTableName())) {
            Schema::create(NotesFieldServiceProvider::getTableName(), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('uuid');
                $table->morphs('commentable');
                $table->text('comment');
                $table->boolean('is_approved')->default(false);
                $table->unsignedBigInteger('user_id')->nullable();

                $table->index('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists(NotesFieldServiceProvider::getTableName());
    }
}
