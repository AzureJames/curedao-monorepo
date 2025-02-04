<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Properties\User\UserIdProperty;
use App\Variables\CommonVariables\EmotionsCommonVariables\OverallMoodCommonVariable;

class UserVariableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
//            'alias' => $this->faker->word,
//            'analysis_ended_at' => $this->faker->date('Y-m-d H:i:s'),
//            'analysis_requested_at' => $this->faker->date('Y-m-d H:i:s'),
//            'analysis_settings_modified_at' => $this->faker->date('Y-m-d H:i:s'),
//            'analysis_started_at' => $this->faker->date('Y-m-d H:i:s'),
//            'average_seconds_between_measurements' => $this->faker->randomDigitNotNull,
//            'best_cause_variable_id' => null,
//            'best_effect_variable_id' => null,
//            'best_user_correlation_id' => null,
//            'cause_only' => $this->faker->word,
//            'charts' => null,
//            'client_id' => BaseClientIdProperty::CLIENT_ID_OAUTH_TEST_CLIENT,
//            'combination_operation' => $this->faker->word,
//            'created_at' => $this->faker->date('Y-m-d H:i:s'),
//            'data_sources_count' => null,
//            'default_unit_id' => OneToFiveRatingUnit::ID,
//            'deleted_at' => null,
//            'description' => $this->faker->text,
            //        'earliest_filling_time' => $this->faker->unixTime,
            //        'earliest_non_tagged_measurement_start_at' => $this->faker->date('Y-m-d H:i:s'),
            //        'earliest_source_measurement_start_at' => $this->faker->date('Y-m-d H:i:s'),
            //        'earliest_tagged_measurement_start_at' => $this->faker->date('Y-m-d H:i:s'),
//            'experiment_end_time' => $this->faker->date('Y-m-d H:i:s'),
//            'experiment_start_time' => $this->faker->date('Y-m-d H:i:s'),
            //        'filling_type' => $this->faker->word,
            //        'filling_value' => $this->faker->randomDigitNotNull,
//            'informational_url' => $this->faker->url,
//            'internal_error_message' => $this->faker->word,
//            'join_with' => $this->faker->randomDigitNotNull,
//            'kurtosis' => $this->faker->randomDigitNotNull,
            //        'last_correlated_at' => $this->faker->date('Y-m-d H:i:s'),
            //        'last_original_unit_id' => OneToFiveRatingUnit::ID,
            //        'last_original_value' => $this->faker->randomDigitNotNull,
            //        'last_processed_daily_value' => $this->faker->randomDigitNotNull,
            //        'last_unit_id' => OneToFiveRatingUnit::ID,
            //        'last_value' => $this->faker->randomDigitNotNull,
            //        'latest_filling_time' => $this->faker->unixTime,
            //        'latest_non_tagged_measurement_start_at' => $this->faker->date('Y-m-d H:i:s'),
            //        'latest_source_measurement_start_at' => $this->faker->date('Y-m-d H:i:s'),
            //        'latest_tagged_measurement_start_at' => $this->faker->date('Y-m-d H:i:s'),
//            'latitude' => $this->faker->randomDigitNotNull,
//            'location' => $this->faker->word,
//            'longitude' => $this->faker->randomDigitNotNull,
//            'maximum_allowed_value' => $this->faker->randomDigitNotNull,
//            'maximum_recorded_value' => $this->faker->randomDigitNotNull,
//            'mean' => $this->faker->randomDigitNotNull,
//            'measurements_at_last_analysis' => $this->faker->randomDigitNotNull,
//            'median' => $this->faker->randomDigitNotNull,
//            'median_seconds_between_measurements' => $this->faker->randomDigitNotNull,
//            'minimum_allowed_seconds_between_measurements' => $this->faker->randomDigitNotNull,
//            'minimum_allowed_value' => $this->faker->randomDigitNotNull,
//            'minimum_recorded_value' => $this->faker->randomDigitNotNull,
//            'most_common_connector_id' => FitbitConnector::ID,
//            'most_common_original_unit_id' => $this->faker->randomDigitNotNull,
//            'most_common_source_name' => $this->faker->word,
//            'most_common_value' => $this->faker->randomDigitNotNull,
//            'newest_data_at' => $this->faker->date('Y-m-d H:i:s'),
//            'number_of_changes' => $this->faker->randomDigitNotNull,
//            'number_of_correlations' => $this->faker->randomDigitNotNull,
//            'number_of_measurements_with_tags_at_last_correlation' => $this->faker->randomDigitNotNull,
//            'number_of_processed_daily_measurements' => $this->faker->randomDigitNotNull,
//            'number_of_measurements' => $this->faker->randomDigitNotNull,
//            'number_of_raw_measurements_with_tags_joins_children' => $this->faker->randomDigitNotNull,
//            'number_of_soft_deleted_measurements' => $this->faker->randomDigitNotNull,
//            'number_of_tracking_reminders' => $this->faker->randomDigitNotNull,
//            'number_of_unique_daily_values' => $this->faker->randomDigitNotNull,
//            'number_of_unique_values' => $this->faker->randomDigitNotNull,
//            'number_of_user_correlations_as_cause' => $this->faker->randomDigitNotNull,
//            'number_of_user_correlations_as_effect' => $this->faker->randomDigitNotNull,
//            'onset_delay' => 3600,
//            'optimal_value_message' => $this->faker->word,
//            'outcome' => $this->faker->word,
//            'outcome_of_interest' => $this->faker->word,
//            'parent_id' => $this->faker->randomDigitNotNull,
//            'predictor_of_interest' => $this->faker->word,
            //'public' => $this->faker->randomDigitNotNull,
//            'reason_for_analysis' => $this->faker->word,
//            'second_to_last_value' => $this->faker->randomDigitNotNull,
//            'is_public' => $this->faker->word,
//            'skewness' => $this->faker->randomDigitNotNull,
//            'standard_deviation' => $this->faker->randomDigitNotNull,
//            'status' => $this->faker->word,
//            'third_to_last_value' => $this->faker->randomDigitNotNull,
//            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
//            'user_error_message' => $this->faker->word,
            'user_id' => UserIdProperty::USER_ID_TEST_USER,
//            'user_maximum_allowed_daily_value' => $this->faker->randomDigitNotNull,
//            'user_minimum_allowed_daily_value' => $this->faker->randomDigitNotNull,
//            'user_minimum_allowed_non_zero_value' => $this->faker->randomDigitNotNull,
//            'valence' => $this->faker->word,
//            'variable_category_id' => EmotionsVariableCategory::ID,
            'variable_id' => OverallMoodCommonVariable::ID,
            //'variance' => $this->faker->randomDigitNotNull,
            //'wikipedia_title' => $this->faker->word,
            //'wp_post_id' => null,
        ];
    }
}
