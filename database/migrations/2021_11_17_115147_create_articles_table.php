<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->default(null)->comment('投稿者のID');
            $table->unsignedBigInteger('image_id')->nullable()->default(null)->comment('記事のアイキャッチ');
            $table->string('title', 100)->default('')->comment('記事のタイトル');
            $table->text('entry')->comment('記事の本文');
            $table->string('permalink', 20)->unique()->default('')->comment('記事のパーマリンク');
            $table->dateTime('publish_at')->nullable()->default(null)->comment('記事の公開日');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('SET NULL');
            $table->foreign('image_id')->references('id')->on('images')->onUpdate('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
