<?php

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Administrator::class);
            $table->text('title')->nullable();
            $table->text('request_reference_no')->nullable();
            $table->integer('case_id')->nullable();
            $table->integer('review_by_id')->nullable();
            $table->text('type_of_crimes_investigated')->nullable();
            $table->text('description_of_circumstances')->nullable();
            $table->text('purpose_for_information_request')->nullable();
            $table->text('connection_btw_information_request')->nullable();
            $table->text('identity_of_the_persons')->nullable();
            $table->text('reasons_tobe_in_member_state')->nullable();
            $table->text('reason_for_request')->nullable();
            $table->text('review_on')->nullable();
            $table->string('review_status')->nullable();
            $table->text('review_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information_requests');
    }
}
