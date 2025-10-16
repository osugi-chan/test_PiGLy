<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColoriesToCaloriesInWeightLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weight_logs', function (Blueprint $table) {
            $table->renameColumn('colories', 'calories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('weight_logs', function (Blueprint $table) {
            $table->renameColumn('calories', 'colories');
        });
    }
}
