<?php

use App\Models\CaseModel;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_contributors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(CaseModel::class)->constrained();
            $table->foreignIdFor(Administrator::class);
            $table->string('notified')->nullable()->default('No');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_contributors');
    }
}
