<?php

use App\Models\CaseModel;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToCaseModelFindings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_model_findings', function (Blueprint $table) {
            //
            $table->foreignIdFor(Administrator::class);
            $table->text('title')->nullable()->nullable();
            $table->text('details')->nullable()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_model_findings', function (Blueprint $table) {
            //
        });
    }
}
