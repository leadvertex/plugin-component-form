<?php
/**
 * Created for plugin-component-form
 * Date: 04.02.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values;


class DynamicValues implements ValuesListInterface
{

    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function get(): string
    {
        return $this->url;
    }

    public function jsonSerialize()
    {
        return $this->get();
    }
}