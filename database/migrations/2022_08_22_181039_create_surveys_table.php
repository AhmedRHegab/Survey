<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('step_id');
            $table->unsignedBigInteger('group_id');
            $table->text('notes')->nullable();
            $table->enum('type',['general', 'building','safeSecurity']);
            $table->string('no_security')->nullable();
            $table->string('no_unit')->nullable();
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade")->cascadeOnUpdate();
            $table->foreign("step_id")->references("id")->on("steps")->onDelete("cascade")->cascadeOnUpdate();
            $table->foreign("group_id")->references("id")->on("groups")->onDelete("cascade")->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
