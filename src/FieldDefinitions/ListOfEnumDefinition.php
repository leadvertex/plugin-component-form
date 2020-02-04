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

    /** @var ValuesListInterface */
    private $values;

    /** @var Limit|null */
    private $limit;

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

    /**
     * @return Limit|null
     */
    public function getLimit(): ?Limit
    {
        return $this->limit;
    }

    /**
     * @return ValuesListInterface
     */
    public function getValues(): ValuesListInterface
    {
        return $this->values;
    }

    /**
     * @return string
     */
    public function definition(): string
    {
        return 'listOfEnum';
    }

}