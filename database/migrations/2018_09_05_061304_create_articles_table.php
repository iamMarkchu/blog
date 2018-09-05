<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string("url_name")->unique()->comment("站内链接");
            $table->string("title")->unique()->comment("文章标题");
            $table->text("content")->comment("文章内容，为markdown格式内容");
            $table->string("cover")->default("")->comment("文章封面");
            $table->tinyInteger("display_order")->default(99)->unsigned()->comment("排序字段");
            $table->tinyInteger("status")->default(0)->unsigned()->comment("文章状态, 1=> 正常，2=> 删除, 0=> 待发布");
            $table->tinyInteger("source")->default(1)->unsigned()->comment("文章来源, 1=> 原创，2=> 转载");
            $table->integer("click_count")->default(0)->unsigned()->comment("文章点击次数");
            $table->integer("vote_count")->default(0)->unsigned()->comment("文章点赞次数");
            $table->integer("user_id")->unsigned()->comment("作者id");
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
        Schema::dropIfExists('articles');
    }
}
