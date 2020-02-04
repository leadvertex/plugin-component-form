<?php
/**
 * Created for plugin-component-form
 * Date: 04.02.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum;


class Limit
{

    /**
     * @var int|null
     */
    private $min;
    /**
     * @var int|null
     */
    private $max;

    public function __construct(?int $min, ?int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @return int|null
     */
    public function getMin(): ?int
    {
        return $this->min;
    }

    /**
     * @return int|null
     */
    public function getMax(): ?int
    {
        return $this->max;
    }

}