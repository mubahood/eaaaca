<?php

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('model')->nullable();
            $table->text('controller')->nullable();
            $table->text('url')->nullable();
            $table->text('body')->nullable();
            $table->foreignIdFor(Administrator::class, 'receiver_id')->nullable();
            $table->string('status')->nullable()->default('Unread');
            $table->string('is_sent')->nullable()->default('No');
            $table->string('priority')->nullable()->default('Moderate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
