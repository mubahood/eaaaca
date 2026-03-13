<?php

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionBoardPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussion_board_posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Administrator::class);
            $table->text('topic')->nullable();
            $table->text('photo')->nullable();
            $table->text('details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discussion_board_posts');
    }
}
