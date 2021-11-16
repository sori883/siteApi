<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('article_id')->comment('記事のID');
            $table->string('title', 100)->default('名無し')->comment('コメント投稿者名');
            $table->text('comment_entry')->comment('コメントの本文');
            $table->dateTime('publish_at')->nullable()->default(null)->comment('コメントの承認日');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
