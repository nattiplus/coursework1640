<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('title',200);
            $table->text('description');
            $table->text('content');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('submission_id');
            $table->boolean('isApprove')->nullable();
            $table->boolean('isAnonymous')->nullable();
            $table->timestamp('create_date')->nullable();
            $table->timestamp('last_modified_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ideas');
    }
}
