<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->tinyInteger("status")->default(0)->unsigned()->comment("状态, 1=> 正常，2=> 删除");
            $table->tinyInteger("level")->default(1)->unsigned()->comment("用户等级, 1=> 普通, 2=> 后台用户, 3=>管理员");
            $table->string("avatar")->default("")->comment("用户头像");
            $table->integer("github_id")->default(0)->unsigned()->comment("github id");
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
        Schema::dropIfExists('users');
    }
}
