<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_contents', function (Blueprint $table) {
            $table->id();
            $table->json('categories_id');
            $table->string('title',255);
            $table->string('slug');
            $table->longText('description');
            $table->string('mata_title')->nullable();
            $table->string('mata_description')->nullable();
            $table->integer('views')->default('0');
            $table->string('image')->nullable();
            $table->enum('status', ['0','1', '2'])->default('0')->comment('0 = Draft, 1 = Published, 2 = Private');
            $table->integer('created_by')->default(0);
            $table->timestamps();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_contents');
    }
}
