<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCtConditionCauseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ct_condition_cause', function (Blueprint $table) {
            $table->foreign(['cause_id'], 'ct_condition_cause_ct_causes_cause_fk')->references(['id'])->deferrable()->on('ct_causes');
            $table->foreign(['condition_id'], 'ct_condition_cause_ct_conditions_id_condition_fk')->references(['id'])->deferrable()->on('ct_conditions');
            $table->foreign(['condition_variable_id'], 'ct_condition_cause_variables_id_condition_fk')->references(['id'])->deferrable()->on('variables');
            $table->foreign(['cause_variable_id'], 'ct_condition_cause_variables_id_fk')->references(['id'])->deferrable()->on('variables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ct_condition_cause', function (Blueprint $table) {
            $table->dropForeign('ct_condition_cause_ct_causes_cause_fk');
            $table->dropForeign('ct_condition_cause_ct_conditions_id_condition_fk');
            $table->dropForeign('ct_condition_cause_variables_id_condition_fk');
            $table->dropForeign('ct_condition_cause_variables_id_fk');
        });
    }
}
