<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileuploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fileuploads', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('file_path');
            $table->string('description');
            $table->timestamp('create_date')->nullable();
            $table->timestamp('last_modified_date')->nullable();
            $table->integer('idea_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fileuploads');
    }
}
