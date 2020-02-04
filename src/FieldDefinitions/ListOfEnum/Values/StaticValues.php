<?php
/**
 * Created for plugin-component-form
 * Date: 04.02.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values;


class StaticValues implements ValuesListInterface
{

    /**
     * @var array
     */
    private $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function get()
    {
        return $this->values;
    }

}