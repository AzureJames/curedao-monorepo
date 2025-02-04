<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Http\Resources;

use App\Types\QMStr;
use Illuminate\Http\Request;

/** @mixin \App\Models\Variable */
class VariableResource extends BaseJsonResource
{
    use ResourceHasCharts;
    /**
     * Indicates if the resource's collection keys should be preserved.
     *
     * @var bool
     */
    public bool $preserveKeys = true;
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $arr = [];
        $arr = $this->addChartsOrUrl($arr);
        $arr = array_merge($arr, [
            'title' => $this->getTitleAttribute(),
            'id' => $this->id,
            'name' => $this->name,
            'subtitle' => $this->getSubtitleAttribute(),
            'common_alias' => $this->common_alias,
            'slug' => $this->getSlugWithNames(),
            'synonyms' => $this->synonyms,
            'string_id' => QMStr::snakize($this->name),
            //'abbreviatedUnitName' => $this->abbreviatedUnitName,
            //'actions_count' => $this->actions_count,
            'additional_meta_data' => $this->additional_meta_data,
            'aggregate_correlations_count' => $this->aggregate_correlations_count,
            'aggregate_correlations_where_cause_variable_count' => $this->aggregate_correlations_where_cause_variable_count,
            'aggregate_correlations_where_effect_variable_count' => $this->aggregate_correlations_where_effect_variable_count,
            'analysis_ended_at' => $this->analysis_ended_at,
            'analysis_requested_at' => $this->analysis_requested_at,
            'analysis_settings_modified_at' => $this->analysis_settings_modified_at,
            'analysis_started_at' => $this->analysis_started_at,
//            'applications_where_outcome_variable_count' => $this->applications_where_outcome_variable_count,
//            'applications_where_predictor_variable_count' => $this->applications_where_predictor_variable_count,
            'average_seconds_between_measurements' => $this->average_seconds_between_measurements,
            'best_aggregate_correlation_id' => $this->best_aggregate_correlation_id,
            'best_cause_variable' => new VariableResource($this->whenLoaded('best_cause_variable')),
            //'best_cause_variable' => new VariableResource($this->whenLoaded('best_cause_variable')),
            'best_cause_variable_id' => $this->best_cause_variable_id,
            'best_effect_variable' => new VariableResource($this->whenLoaded('best_effect_variable')),
            //'best_effect_variable' => new VariableResource($this->whenLoaded('best_effect_variable')),
            'best_effect_variable_id' => $this->best_effect_variable_id,
            'boring' => $this->boring,
            'brand_name' => $this->brand_name,
            'canonical_variable_id' => $this->canonical_variable_id,
            'cause_only' => $this->cause_only,
            'charts' => $this->charts,
            'client_id' => $this->client_id,
            'combination_operation' => $this->combination_operation,
            'common_maximum_allowed_daily_value' => $this->common_maximum_allowed_daily_value,
            'common_minimum_allowed_daily_value' => $this->common_minimum_allowed_daily_value,
            'common_minimum_allowed_non_zero_value' => $this->common_minimum_allowed_non_zero_value,
            'common_tagged_by_count' => $this->common_tagged_by_count,
            'common_tags_count' => $this->common_tags_count,
            'common_tags_where_tag_variable_count' => $this->common_tags_where_tag_variable_count,
            'common_tags_where_tagged_variable_count' => $this->common_tags_where_tagged_variable_count,
            'condition_causes_where_cause_count' => $this->condition_causes_where_cause_count,
            'condition_causes_where_condition_count' => $this->condition_causes_where_condition_count,
            'condition_treatments_count' => $this->condition_treatments_count,
            'condition_treatments_where_condition_count' => $this->condition_treatments_where_condition_count,
            'condition_treatments_where_treatment_count' => $this->condition_treatments_where_treatment_count,
            'controllable' => $this->controllable,
            'correlation_causality_votes_where_cause_variable_count' => $this->correlation_causality_votes_where_cause_variable_count,
            'correlation_causality_votes_where_effect_variable_count' => $this->correlation_causality_votes_where_effect_variable_count,
            'correlation_usefulness_votes_where_cause_variable_count' => $this->correlation_usefulness_votes_where_cause_variable_count,
            'correlation_usefulness_votes_where_effect_variable_count' => $this->correlation_usefulness_votes_where_effect_variable_count,
            'correlations_count' => $this->correlations_count,
            'correlations_where_cause_variable' => CorrelationResource::collection($this->whenLoaded('correlations_where_cause_variable')),
            //'correlations_where_cause_variable' => CorrelationResource::collection($this->whenLoaded
            //('correlations_where_cause_variable')),
            'correlations_where_cause_variable_count' => $this->correlations_where_cause_variable_count,
            'correlations_where_effect_variable' => CorrelationResource::collection($this->whenLoaded('correlations_where_effect_variable')),
            //'correlations_where_effect_variable' => CorrelationResource::collection($this->whenLoaded
            //('correlations_where_effect_variable')),
            'correlations_where_effect_variable_count' => $this->correlations_where_effect_variable_count,
            'created_at' => $this->created_at,
            //'creator_user' => new UserResource($this->whenLoaded('creator_user')),
            //'creator_user' => new UserResource($this->whenLoaded('creator_user')),
            //'creator_user_id' => $this->creator_user_id,
            'ct_treatment_side_effects_where_side_effect_variable_count' => $this->ct_treatment_side_effects_where_side_effect_variable_count,
            'ct_treatment_side_effects_where_treatment_variable_count' => $this->ct_treatment_side_effects_where_treatment_variable_count,
            'data_sources_count' => $this->data_sources_count,
            'default_unit_id' => $this->default_unit_id,
            'default_unit_name' => $this->getUnit()->name,
            'default_value' => $this->default_value,
            //'deletion_reason' => $this->deletion_reason,
            'description' => $this->description,
            //'display_name' => $this->display_name,
            'duration_of_action' => $this->duration_of_action,
            'earliest_non_tagged_measurement_start_at' => $this->earliest_non_tagged_measurement_start_at,
            'earliest_tagged_measurement_start_at' => $this->earliest_tagged_measurement_start_at,
            //'favoriters' => UserCollection::collection($this->whenLoaded('favoriters')),
            //'favoriters' => UserCollection::collection($this->whenLoaded('favoriters')),
            //'favoriters_count' => $this->favoriters_count,
            //'favorites_count' => $this->favorites_count,
            'filling_type' => $this->filling_type,
            'filling_value' => $this->filling_value,
            'image_url' => $this->image_url,
            //'individual_cause_studies' => CorrelationResource::collection($this->whenLoaded
            //('individual_cause_studies')),
            //'individual_cause_studies' => CorrelationResource::collection($this->whenLoaded
            //('individual_cause_studies')),
            'individual_cause_studies_count' => $this->individual_cause_studies_count,
            //'individual_effect_studies' => CorrelationResource::collection($this->whenLoaded
            //('individual_effect_studies')),
            //'individual_effect_studies' => CorrelationResource::collection($this->whenLoaded
            //('individual_effect_studies')),
            'individual_effect_studies_count' => $this->individual_effect_studies_count,
            'informational_url' => $this->informational_url,
            //'internal_error_message' => $this->internal_error_message,
            'ion_icon' => $this->ion_icon,
            'is_goal' => $this->is_goal,
            'is_public' => $this->is_public,
            'kurtosis' => $this->kurtosis,
            'latest_non_tagged_measurement_start_at' => $this->latest_non_tagged_measurement_start_at,
            'latest_tagged_measurement_start_at' => $this->latest_tagged_measurement_start_at,
            'manual_tracking' => $this->manual_tracking,
            'maximum_allowed_daily_value' => $this->maximum_allowed_daily_value,
            'maximum_allowed_value' => $this->maximum_allowed_value,
            'maximum_recorded_value' => $this->maximum_recorded_value,
            'mean' => $this->mean,
            'measurements_count' => $this->measurements_count,
            //'media_count' => $this->media_count,
            'median' => $this->median,
            'median_seconds_between_measurements' => $this->median_seconds_between_measurements,
            'meta_data' => $this->meta_data,
            'minimum_allowed_seconds_between_measurements' => $this->minimum_allowed_seconds_between_measurements,
            'minimum_allowed_value' => $this->minimum_allowed_value,
            'minimum_recorded_value' => $this->minimum_recorded_value,
            'most_common_connector_id' => $this->most_common_connector_id,
            'most_common_original_unit_id' => $this->most_common_original_unit_id,
            'most_common_source_name' => $this->most_common_source_name,
            'most_common_value' => $this->most_common_value,
            'newest_data_at' => $this->newest_data_at,
            'number_common_tagged_by' => $this->number_common_tagged_by,
            'number_of_aggregate_correlations_as_cause' => $this->number_of_aggregate_correlations_as_cause,
            'number_of_aggregate_correlations_as_effect' => $this->number_of_aggregate_correlations_as_effect,
            'number_of_applications_where_outcome_variable' => $this->number_of_applications_where_outcome_variable,
            'number_of_applications_where_predictor_variable' => $this->number_of_applications_where_predictor_variable,
            'number_of_common_children' => $this->number_of_common_children,
            'number_of_common_foods' => $this->number_of_common_foods,
            'number_of_common_ingredients' => $this->number_of_common_ingredients,
            'number_of_common_joined_variables' => $this->number_of_common_joined_variables,
            'number_of_common_parents' => $this->number_of_common_parents,
            'number_of_common_tags' => $this->number_of_common_tags,
            'number_of_common_tags_where_tag_variable' => $this->number_of_common_tags_where_tag_variable,
            'number_of_common_tags_where_tagged_variable' => $this->number_of_common_tags_where_tagged_variable,
            'number_of_measurements' => $this->number_of_measurements,
            'number_of_outcome_case_studies' => $this->number_of_outcome_case_studies,
            'number_of_outcome_population_studies' => $this->number_of_outcome_population_studies,
            'number_of_predictor_case_studies' => $this->number_of_predictor_case_studies,
            'number_of_predictor_population_studies' => $this->number_of_predictor_population_studies,
            'number_of_raw_measurements' => $this->number_of_raw_measurements,
            'number_of_raw_measurements_with_tags_joins_children' => $this->number_of_raw_measurements_with_tags_joins_children,
            'number_of_soft_deleted_measurements' => $this->number_of_soft_deleted_measurements,
            'number_of_studies_where_cause_variable' => $this->number_of_studies_where_cause_variable,
            'number_of_studies_where_effect_variable' => $this->number_of_studies_where_effect_variable,
            'number_of_tracking_reminder_notifications' => $this->number_of_tracking_reminder_notifications,
            'number_of_tracking_reminders' => $this->number_of_tracking_reminders,
            'number_of_unique_values' => $this->number_of_unique_values,
            'number_of_user_children' => $this->number_of_user_children,
            'number_of_user_foods' => $this->number_of_user_foods,
            'number_of_user_ingredients' => $this->number_of_user_ingredients,
            'number_of_user_joined_variables' => $this->number_of_user_joined_variables,
            'number_of_user_parents' => $this->number_of_user_parents,
            'number_of_user_tags_where_tag_variable' => $this->number_of_user_tags_where_tag_variable,
            'number_of_user_tags_where_tagged_variable' => $this->number_of_user_tags_where_tagged_variable,
            'number_of_user_variables' => $this->number_of_user_variables,
            'number_of_users_where_primary_outcome_variable' => $this->number_of_users_where_primary_outcome_variable,
            'number_of_variables_where_best_cause_variable' => $this->number_of_variables_where_best_cause_variable,
            'number_of_variables_where_best_effect_variable' => $this->number_of_variables_where_best_effect_variable,
            'number_of_votes_where_cause_variable' => $this->number_of_votes_where_cause_variable,
            'number_of_votes_where_effect_variable' => $this->number_of_votes_where_effect_variable,
            'onset_delay' => $this->onset_delay,
            'optimal_value_message' => $this->optimal_value_message,
            'outcome' => $this->outcome,
            'outcomes_count' => $this->outcomes_count,
            'parent_id' => $this->parent_id,
            'population_cause_studies_count' => $this->population_cause_studies_count,
            'population_effect_studies_count' => $this->population_effect_studies_count,
            'predictor' => $this->predictor,
            'predictors_count' => $this->predictors_count,
            'price' => $this->price,
            'product_url' => $this->product_url,
            //'public' => $this->public,
            'public_outcomes_count' => $this->public_outcomes_count,
            'public_predictors_count' => $this->public_predictors_count,
            'reason_for_analysis' => $this->reason_for_analysis,
            'record_size_in_kb' => $this->record_size_in_kb,
            'second_most_common_value' => $this->second_most_common_value,
            'side_effect_variables' => VariableResource::collection($this->whenLoaded('side_effect_variables')),
            'side_effect_variables_count' => $this->side_effect_variables_count,
            'side_effects_count' => $this->side_effects_count,
            'skewness' => $this->skewness,
            'sort_order' => $this->sort_order,
            'source_url' => $this->source_url,
            'standard_deviation' => $this->standard_deviation,
            //'status' => $this->status,
            'studies_count' => $this->studies_count,
            'studies_where_cause_variable_count' => $this->studies_where_cause_variable_count,
            'studies_where_effect_variable_count' => $this->studies_where_effect_variable_count,
            'tags_count' => $this->tags_count,
            'third_most_common_value' => $this->third_most_common_value,
            'third_party_correlations_count' => $this->third_party_correlations_count,
            'tracking_reminder_notifications_count' => $this->tracking_reminder_notifications_count,
            'tracking_reminders_count' => $this->tracking_reminders_count,
            'treatment_side_effects_where_treatment_count' => $this->treatment_side_effects_where_treatment_count,
            //'unit_id' => $this->unit_id,
            'up_voted_public_outcomes_count' => $this->up_voted_public_outcomes_count,
            'up_voted_public_predictors_count' => $this->up_voted_public_predictors_count,
            'upc_12' => $this->upc_12,
            'upc_14' => $this->upc_14,
            'updated_at' => $this->updated_at,
            'user_error_message' => $this->user_error_message,
            'user_tagged_by_count' => $this->user_tagged_by_count,
            'user_tags_count' => $this->user_tags_count,
            'user_tags_where_tag_variable_count' => $this->user_tags_where_tag_variable_count,
            'user_tags_where_tagged_variable_count' => $this->user_tags_where_tagged_variable_count,
            'user_variable_clients_count' => $this->user_variable_clients_count,
            'user_variable_outcome_categories_count' => $this->user_variable_outcome_categories_count,
            'user_variable_predictor_categories_count' => $this->user_variable_predictor_categories_count,
            'user_variables_count' => $this->user_variables_count,
            'user_variables_excluding_test_users_count' => $this->user_variables_excluding_test_users_count,
            'users_count' => $this->users_count,
            //'users_where_primary_outcome_variable' => UserCollection::collection($this->whenLoaded
            //('users_where_primary_outcome_variable')),
            //'users_where_primary_outcome_variable' => UserCollection::collection($this->whenLoaded
            //('users_where_primary_outcome_variable')),
            'users_where_primary_outcome_variable_count' => $this->users_where_primary_outcome_variable_count,
            'valence' => $this->valence,
            'variable_category_id' => $this->variable_category_id,
            'variable_category_name' => $this->getQMVariableCategory()->name,
            'variable_id' => $this->variable_id,
            'variable_outcome_categories_count' => $this->variable_outcome_categories_count,
            'variable_predictor_categories_count' => $this->variable_predictor_categories_count,
            'variable_user_sources_count' => $this->variable_user_sources_count,
            'variables_count' => $this->variables_count,
            'variables_where_best_cause_variable' => VariableResource::collection($this->whenLoaded('variables_where_best_cause_variable')),
            //'variables_where_best_cause_variable' => VariableResource::collection($this->whenLoaded
            //('variables_where_best_cause_variable')),
            'variables_where_best_cause_variable_count' => $this->variables_where_best_cause_variable_count,
            'variables_where_best_effect_variable' => VariableResource::collection($this->whenLoaded('variables_where_best_effect_variable')),
            //'loinc_variable' => VariableResource::collection($this->whenLoaded('loinc_variables')),
            //'snomed_variable' => VariableResource::collection($this->whenLoaded('snomed_variable')),
            //'meddra_variable' => VariableResource::collection($this->whenLoaded('meddra_variable')),
            'variables_where_best_effect_variable_count' => $this->variables_where_best_effect_variable_count,
            'variance' => $this->variance,
            'votes_count' => $this->votes_count,
            'votes_where_cause_count' => $this->votes_where_cause_count,
            'votes_where_cause_variable_count' => $this->votes_where_cause_variable_count,
            'votes_where_effect_count' => $this->votes_where_effect_count,
            'votes_where_effect_variable_count' => $this->votes_where_effect_variable_count,
            'wikipedia_title' => $this->wikipedia_title,
            'wikipedia_url' => $this->wikipedia_url,
            //'wp_post_id' => $this->wp_post_id,
        ]);
        $arr = $this->addChartsOrUrl($arr);
        return $arr;
    }
}
