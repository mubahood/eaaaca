<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToCaseModinformationRequestReponses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('information_request_reponses', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\InformationRequest::class, 'information_request_id')->nullable()->constrained('information_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('information_request_reponses', function (Blueprint $table) {
            //
        });
    }
}
