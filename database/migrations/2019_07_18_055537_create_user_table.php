<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    private $table = "user";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->bigInteger('lv_0')->unsigned()->nullable();
                $table->bigInteger('lv_1')->unsigned()->nullable();
                $table->bigInteger('lv_2')->unsigned()->nullable();
                $table->string('account', 30);
                $table->smallInteger('level')->unsigned()->nullable();
                $table->string('password', 100);
                $table->string('nickname', 30);
                $table->string('parents', 255);
                $table->integer('parent_id')->default(0);
                $table->enum('status', ['lock', 'normal', 'delete']);
                $table->enum('role', ['agent', 'member', 'sub']);
                $table->text('notes')->nullable();
                $table->string('api_key', 40);
                $table->string('remember_token', 100)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
