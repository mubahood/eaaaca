<?php

use App\Models\CaseModel;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseModelAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_model_attachments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('name')->nullable()->nullable();
            $table->foreignIdFor(CaseModel::class)->constrained();
            $table->foreignIdFor(Administrator::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_model_attachments');
    }
}
