<?php
/**
 * Created for plugin-component-form
 * Datetime: 29.08.2019 12:40
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


use Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Limit;
use Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values\ValuesListInterface;

class ListOfEnumDefinition extends FieldDefinition
{

    private ValuesListInterface $values;

    private ?Limit $limit;

    public function __construct(
        string $title,
        ?string $description,
        callable $validator,
        ValuesListInterface $valuesList,
        ?Limit $limit,
        $default = null
    )
    {
        parent::__construct($title, $description, $validator, $default);
        $this->values = $valuesList;
        $this->limit = $limit;
    }

    public function getLimit(): ?Limit
    {
        return $this->limit;
    }

    public function getValues(): ValuesListInterface
    {
        return $this->values;
    }


    public function getDefinition(): string
    {
        return 'listOfEnum';
    }

    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'definition' => $this->getDefinition(),
            'default' => $this->getDefault(),
            'limit' => $this->getLimit(),
            'values' => $this->getValues()
        ];
    }

}