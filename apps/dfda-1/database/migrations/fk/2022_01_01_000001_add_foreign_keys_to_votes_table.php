<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->foreign(['aggregate_correlation_id'], 'votes_aggregate_correlations_id_fk')->references(['id'])->deferrable()->on('aggregate_correlations')->onDelete('SET NULL');
            $table->foreign(['cause_variable_id'], 'votes_cause_variable_id_fk')->references(['id'])->deferrable()->on('variables');
            $table->foreign(['client_id'], 'votes_client_id_fk')->references(['client_id'])->on('oa_clients');
            $table->foreign(['correlation_id'], 'votes_correlations_id_fk')->references(['id'])->deferrable()->on('correlations');
            $table->foreign(['effect_variable_id'], 'votes_effect_variable_id_fk_2')->references(['id'])->deferrable()->on('variables');
            $table->foreign(['user_id'], 'votes_user_id_fk')->references(['ID'])->deferrable()->on('wp_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropForeign('votes_aggregate_correlations_id_fk');
            $table->dropForeign('votes_cause_variable_id_fk');
            $table->dropForeign('votes_client_id_fk');
            $table->dropForeign('votes_correlations_id_fk');
            $table->dropForeign('votes_effect_variable_id_fk_2');
            $table->dropForeign('votes_user_id_fk');
        });
    }
}
