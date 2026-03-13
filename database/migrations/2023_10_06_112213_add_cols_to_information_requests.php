<?php

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToInformationRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('information_requests', function (Blueprint $table) {
            $table->foreignIdFor(Administrator::class,'receiver_id')->nullable();
            $table->foreignIdFor(Administrator::class,'receiver_country_id')->nullable();
            $table->foreignIdFor(Administrator::class,'sender_id')->nullable();
            $table->foreignIdFor(Administrator::class,'sender_country_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('information_requests', function (Blueprint $table) {
            //
        });
    }
}
