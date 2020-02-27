<?php
/**
 * Created for plugin-component-form
 * Date: 04.02.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values;


class DynamicValues implements ValuesListInterface
{

    /**
     * @var string
     */
    private $uri;

    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    public function get()
    {
        return $this->uri;
    }

    public function jsonSerialize()
    {
        return $this->get();
    }
}