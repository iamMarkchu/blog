<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title")->comment("素材标题");
            $table->tinyInteger("type")->default(1)->unsigned()->comment("素材类型， 1=>图片");
            $table->tinyInteger("status")->default(1)->unsigned()->comment("状态, 1=> 正常，2=> 删除");
            $table->string("url")->comment("素材链接");
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
        Schema::dropIfExists('materials');
    }
}
