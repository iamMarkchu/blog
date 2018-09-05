<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string("url_name")->unique()->comment("站内链接");
            $table->string("name")->unique()->comment("类别名字");
            $table->integer("parent_id")->unsigned()->comment("父类别id");
            $table->tinyInteger("display_order")->default(99)->unsigned()->comment("排序字段");
            $table->tinyInteger("status")->default(1)->unsigned()->comment("状态, 1=> 正常，2=> 删除");
            $table->integer("user_id")->unsigned()->comment("创建者id");
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
        Schema::dropIfExists('categories');
    }
}
