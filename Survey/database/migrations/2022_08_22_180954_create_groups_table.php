<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('step_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign("step_id")->references("id")->on("steps")->onDelete("cascade")->cascadeOnUpdate();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade")->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
