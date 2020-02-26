<?php
/**
 * Created for plugin-component-form
 * Date: 04.02.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values;


use InvalidArgumentException;

class StaticValues implements ValuesListInterface
{

    /**
     * @var array
     */
    private $values;

    public function __construct(array $values)
    {
        $this->guardArray($values);
        $this->values = $values;
    }

    public function get()
    {
        return $this->values;
    }

    public function jsonSerialize()
    {
        return $this->get();
    }

    private function guardArray(array $array)
    {
        foreach ($array as $values) {
            if (!is_array($values)) {
                throw new InvalidArgumentException('Items has no groups', 1);
            }

            foreach ($values as $value) {
                if (!is_scalar($value)) {
                    throw new InvalidArgumentException('Items has redundant nested level', 2);
                }
            }
        }
    }

}