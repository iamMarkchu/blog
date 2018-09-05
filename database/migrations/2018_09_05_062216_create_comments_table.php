<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->text("content")->comment("评论内容");
            $table->integer("article_id")->comment("文章id");
            $table->integer("parent_id")->comment("父评论id");
            $table->integer("user_id")->comment("评论用户id");
            $table->integer("vote_count")->comment("点赞次数");
            $table->tinyInteger("status")->default(3)->unsigned()->comment("状态, 1=> 正常，2=> 删除, 3=> 待审核");
            $table->timestamps();
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
