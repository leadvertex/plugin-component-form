<?php
/**
 * Created for plugin-export-core
 * Datetime: 04.07.2019 16:18
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme;


use Leadvertex\Plugin\Scheme\Components\i18n;
use Leadvertex\Plugin\Scheme\FieldDefinitions\FieldDefinition;
use TypeError;

class FieldGroup
{

    /**
     * @var i18n
     */
    private $label;
    /**
     * @var FieldDefinition[]
     */
    private $fields;

    /**
     * FieldsGroup constructor.
     * @param i18n $label
     * @param FieldDefinition[] $fields
     */
    public function __construct(i18n $label, array $fields)
    {
        $this->label = $label;

        foreach ($fields as $name => $fieldsGroup) {
            if (!$fieldsGroup instanceof FieldDefinition) {
                throw new TypeError('Every item of $fields should be instance of ' . FieldDefinition::class);
            }
            $this->fields[$name] = $fieldsGroup;
        }
    }

    /**
     * @return i18n
     */
    public function getLabel(): i18n
    {
        return $this->label;
    }

    /**
     * @param string $name
     * @return FieldDefinition
     */
    public function getField(string $name): FieldDefinition
    {
        return $this->fields[$name];
    }

    /**
     * @return FieldDefinition[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function toArray(): array
    {
        $array = [
            'label' => $this->label->toArray(),
            'fields' => [],
        ];
        foreach ($this->getFields() as $fieldName => $fieldDefinition) {
            $array['fields'][$fieldName] = $fieldDefinition->toArray();
        }

        return $array;
    }

}