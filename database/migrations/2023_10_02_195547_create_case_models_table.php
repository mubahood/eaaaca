<?php

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_models', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Administrator::class);
            $table->integer('country_id')->nullable();
            $table->text('title')->nullable();
            $table->string('status')->nullable();
            $table->text('content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_models');
    }
}
