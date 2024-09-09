<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();
            $table->string('name', 255);
            $table->string('email', 50)->unique();
            $table->string('phone', 25);
            $table->string('password')->nullable();
            $table->boolean('owner')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
