<?php
/*
*  GNU General Public License v3.0
*  Contributors: ADD YOUR NAME HERE, Mike P. Sinn
 */

namespace App\Fields;

class Heading extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'heading-field';

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  mixed|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct(null, $attribute, $resolveCallback);

        $this->withMeta(['value' => $name]);
        $this->hideFromIndex();
        $this->withMeta(['asHtml' => false]);
    }

    /**
     * Display the field as raw HTML using Vue.
     *
     * @return $this
     */
    public function asHtml()
    {
        return $this->withMeta(['asHtml' => true]);
    }
}
