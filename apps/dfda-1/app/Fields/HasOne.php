<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Fields;

use Illuminate\Http\Request;
use App\Contracts\ListableField;
use App\Contracts\RelatableField;
use App\Http\Requests\AstralRequest;
use App\Astral;

class HasOne extends Field implements ListableField, RelatableField
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'has-one-field';

    /**
     * The class name of the related resource.
     *
     * @var string
     */
    public $resourceClass;

    /**
     * The URI key of the related resource.
     *
     * @var string
     */
    public $resourceName;

    /**
     * The displayable singular label of the relation.
     *
     * @var string
     */
    public $singularLabel;

    /**
     * The name of the Eloquent "has one" relationship.
     *
     * @var string
     */
    public $hasOneRelationship;

    /**
     * The callback use to determine if the HasOne field has already been filled.
     *
     * @var \Closure
     */
    public $filledCallback;

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  string|null  $resource
     * @return void
     */
    public function __construct($name, $attribute = null, $resource = null)
    {
        parent::__construct($name, $attribute);

        $resource = $resource ?? ResourceRelationshipGuesser::guessResource($name);

        $this->resourceClass = $resource;
        $this->resourceName = $resource::uriKey();
        $this->hasOneRelationship = $this->attribute;
        $this->singularLabel = $resource::singularLabel();

        $this->filledCallback = function ($request) {
            $resource = Astral::resourceForKey($request->viaResource);

            if ($resource && $request->viaResourceId) {
                $parent = $resource::newModel()->find($request->viaResourceId);

                return ! is_null($parent->{$this->attribute});
            }

            return false;
        };
    }

    /**
     * Determine if the field should be displayed for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorize(Request $request)
    {
        return call_user_func(
            [$this->resourceClass, 'authorizedToViewAny'], $request
        ) && parent::authorize($request);
    }

    /**
     * Resolve the field's value.
     *
     * @param  mixed  $resource
     * @param  string|null  $attribute
     * @return void
     */
    public function resolve($resource, $attribute = null)
    {
        //
    }

    /**
     * Set the displayable singular label of the resource.
     *
     * @return $this
     */
    public function singularLabel($singularLabel)
    {
        $this->singularLabel = $singularLabel;

        return $this;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        $request = app(AstralRequest::class);

        return array_merge([
            'resourceName' => $this->resourceName,
            'hasOneRelationship' => $this->hasOneRelationship,
            'listable' => true,
            'singularLabel' => $this->singularLabel,
            'alreadyFilled' => $this->alreadyFilled($request),
        ], parent::jsonSerialize());
    }

    /**
     * Set the Closure used to determine if the HasOne field has already been filled.
     *
     * @param $callback
     */
    public function alreadyFilledWhen($callback)
    {
        $this->filledCallback = $callback;

        return $this;
    }

    /**
     * Determine if the HasOne field has alreaady been filled.
     *
     * @param  \App\Http\Requests\AstralRequest  $request
     * @return bool
     */
    public function alreadyFilled(AstralRequest $request)
    {
        return call_user_func($this->filledCallback, $request) ?? false;
    }
}
