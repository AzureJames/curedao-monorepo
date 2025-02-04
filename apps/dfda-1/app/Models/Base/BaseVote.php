<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

/** @noinspection PhpMissingDocCommentInspection */
/** @noinspection PhpUnused */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
/** Created by Reliese Model.
 */
namespace App\Models\Base;
use App\Models\AggregateCorrelation;
use App\Models\BaseModel;
use App\Models\Correlation;
use App\Models\OAClient;
use App\Models\Variable;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
/** Class BaseVote
 * @property int $id
 * @property string $client_id
 * @property int $user_id
 * @property int $value
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property int $cause_variable_id
 * @property int $effect_variable_id
 * @property int $correlation_id
 * @property int $aggregate_correlation_id
 * @property bool $is_public
 * @property AggregateCorrelation $aggregate_correlation
 * @property Variable $cause_variable
 * @property OAClient $oa_client
 * @property Correlation $correlation
 * @property Variable $effect_variable
 * @property \App\Models\User $user
 * @package App\Models\Base

 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel applyRequestParams($request)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel exclude($columns)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel excludeLargeColumns()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel nPerGroup($group, $n = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Base\BaseVote onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote whereCauseVariableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote whereEffectVariableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseVote whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Base\BaseVote withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Base\BaseVote withoutTrashed()
 * @mixin \Eloquent
 * @property mixed $raw
 * @method static \Illuminate\Database\Eloquent\Builder|BaseVote whereAggregateCorrelationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseVote whereCorrelationId($value)
 */
abstract class BaseVote extends BaseModel {
	use SoftDeletes;
	public const FIELD_AGGREGATE_CORRELATION_ID = 'aggregate_correlation_id';
	public const FIELD_CAUSE_VARIABLE_ID = 'cause_variable_id';
	public const FIELD_CLIENT_ID = 'client_id';
	public const FIELD_CORRELATION_ID = 'correlation_id';
	public const FIELD_CREATED_AT = 'created_at';
	public const FIELD_DELETED_AT = 'deleted_at';
	public const FIELD_EFFECT_VARIABLE_ID = 'effect_variable_id';
	public const FIELD_ID = 'id';
	public const FIELD_IS_PUBLIC = 'is_public';
	public const FIELD_UPDATED_AT = 'updated_at';
	public const FIELD_USER_ID = 'user_id';
	public const FIELD_VALUE = 'value';
	public const TABLE = 'votes';
	protected $table = self::TABLE;
	public const CLASS_DESCRIPTION = '';
	protected $casts = [
        self::FIELD_CREATED_AT => 'datetime',
        self::FIELD_UPDATED_AT => 'datetime',
        self::FIELD_DELETED_AT => 'datetime',
		self::FIELD_AGGREGATE_CORRELATION_ID => 'int',
		self::FIELD_CAUSE_VARIABLE_ID => 'int',
		self::FIELD_CLIENT_ID => 'string',
		self::FIELD_CORRELATION_ID => 'int',
		self::FIELD_EFFECT_VARIABLE_ID => 'int',
		self::FIELD_ID => 'int',
		self::FIELD_IS_PUBLIC => 'bool',
		self::FIELD_USER_ID => 'int',
		self::FIELD_VALUE => 'int',	];
	protected array $rules = [
		self::FIELD_AGGREGATE_CORRELATION_ID => 'nullable|integer|min:-2147483648|max:2147483647',
		self::FIELD_CAUSE_VARIABLE_ID => 'required|integer|min:0|max:2147483647',
		self::FIELD_CLIENT_ID => 'nullable|max:80',
		self::FIELD_CORRELATION_ID => 'nullable|integer|min:-2147483648|max:2147483647',
		self::FIELD_EFFECT_VARIABLE_ID => 'required|integer|min:0|max:2147483647',
		self::FIELD_IS_PUBLIC => 'nullable|boolean',
		self::FIELD_USER_ID => 'required|numeric|min:0',
		self::FIELD_VALUE => 'required|integer|min:-2147483648|max:2147483647',
	];
	protected $hints = [
		self::FIELD_ID => '',
		self::FIELD_CLIENT_ID => '',
		self::FIELD_USER_ID => '',
		self::FIELD_VALUE => 'Value of Vote',
		self::FIELD_CREATED_AT => 'datetime',
		self::FIELD_UPDATED_AT => 'datetime',
		self::FIELD_DELETED_AT => 'datetime',
		self::FIELD_CAUSE_VARIABLE_ID => '',
		self::FIELD_EFFECT_VARIABLE_ID => '',
		self::FIELD_CORRELATION_ID => '',
		self::FIELD_AGGREGATE_CORRELATION_ID => '',
		self::FIELD_IS_PUBLIC => '',
	];
	protected array $relationshipInfo = [
		'aggregate_correlation' => [
			'relationshipType' => 'BelongsTo',
			'qualifiedUserClassName' => AggregateCorrelation::class,
			'foreignKeyColumnName' => 'aggregate_correlation_id',
			'foreignKey' => Vote::FIELD_AGGREGATE_CORRELATION_ID,
			'otherKeyColumnName' => 'id',
			'otherKey' => AggregateCorrelation::FIELD_ID,
			'ownerKeyColumnName' => 'aggregate_correlation_id',
			'ownerKey' => Vote::FIELD_AGGREGATE_CORRELATION_ID,
			'methodName' => 'aggregate_correlation',
		],
		'cause_variable' => [
			'relationshipType' => 'BelongsTo',
			'qualifiedUserClassName' => Variable::class,
			'foreignKeyColumnName' => 'cause_variable_id',
			'foreignKey' => Vote::FIELD_CAUSE_VARIABLE_ID,
			'otherKeyColumnName' => 'id',
			'otherKey' => Variable::FIELD_ID,
			'ownerKeyColumnName' => 'cause_variable_id',
			'ownerKey' => Vote::FIELD_CAUSE_VARIABLE_ID,
			'methodName' => 'cause_variable',
		],
		'oa_client' => [
			'relationshipType' => 'BelongsTo',
			'qualifiedUserClassName' => OAClient::class,
			'foreignKeyColumnName' => 'client_id',
			'foreignKey' => Vote::FIELD_CLIENT_ID,
			'otherKeyColumnName' => 'client_id',
			'otherKey' => OAClient::FIELD_CLIENT_ID,
			'ownerKeyColumnName' => 'client_id',
			'ownerKey' => Vote::FIELD_CLIENT_ID,
			'methodName' => 'oa_client',
		],
		'correlation' => [
			'relationshipType' => 'BelongsTo',
			'qualifiedUserClassName' => Correlation::class,
			'foreignKeyColumnName' => 'correlation_id',
			'foreignKey' => Vote::FIELD_CORRELATION_ID,
			'otherKeyColumnName' => 'id',
			'otherKey' => Correlation::FIELD_ID,
			'ownerKeyColumnName' => 'correlation_id',
			'ownerKey' => Vote::FIELD_CORRELATION_ID,
			'methodName' => 'correlation',
		],
		'effect_variable' => [
			'relationshipType' => 'BelongsTo',
			'qualifiedUserClassName' => Variable::class,
			'foreignKeyColumnName' => 'effect_variable_id',
			'foreignKey' => Vote::FIELD_EFFECT_VARIABLE_ID,
			'otherKeyColumnName' => 'id',
			'otherKey' => Variable::FIELD_ID,
			'ownerKeyColumnName' => 'effect_variable_id',
			'ownerKey' => Vote::FIELD_EFFECT_VARIABLE_ID,
			'methodName' => 'effect_variable',
		],
		'user' => [
			'relationshipType' => 'BelongsTo',
			'qualifiedUserClassName' => \App\Models\User::class,
			'foreignKeyColumnName' => 'user_id',
			'foreignKey' => Vote::FIELD_USER_ID,
			'otherKeyColumnName' => 'ID',
			'otherKey' => \App\Models\User::FIELD_ID,
			'ownerKeyColumnName' => 'user_id',
			'ownerKey' => Vote::FIELD_USER_ID,
			'methodName' => 'user',
		],
	];
	public function aggregate_correlation(): BelongsTo{
		return $this->belongsTo(AggregateCorrelation::class, Vote::FIELD_AGGREGATE_CORRELATION_ID,
			AggregateCorrelation::FIELD_ID, Vote::FIELD_AGGREGATE_CORRELATION_ID);
	}
	public function cause_variable(): BelongsTo{
		return $this->belongsTo(Variable::class, Vote::FIELD_CAUSE_VARIABLE_ID, Variable::FIELD_ID,
			Vote::FIELD_CAUSE_VARIABLE_ID);
	}
	public function oa_client(): BelongsTo{
		return $this->belongsTo(OAClient::class, Vote::FIELD_CLIENT_ID, OAClient::FIELD_CLIENT_ID,
			Vote::FIELD_CLIENT_ID);
	}
	public function correlation(): BelongsTo{
		return $this->belongsTo(Correlation::class, Vote::FIELD_CORRELATION_ID, Correlation::FIELD_ID,
			Vote::FIELD_CORRELATION_ID);
	}
	public function effect_variable(): BelongsTo{
		return $this->belongsTo(Variable::class, Vote::FIELD_EFFECT_VARIABLE_ID, Variable::FIELD_ID,
			Vote::FIELD_EFFECT_VARIABLE_ID);
	}
	public function user(): BelongsTo{
		return $this->belongsTo(\App\Models\User::class, Vote::FIELD_USER_ID, \App\Models\User::FIELD_ID,
			Vote::FIELD_USER_ID);
	}
}
