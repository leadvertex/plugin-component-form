<?php
/**
 * Created for plugin-form
 * Datetime: 04.07.2019 16:18
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Form;


use Leadvertex\Plugin\Form\FieldDefinitions\FieldDefinition;
use Leadvertex\Plugin\I18n\I18nInterface;
use TypeError;

class FieldGroup
{

    /**
     * @var I18nInterface
     */
    private $label;
    /**
     * @var FieldDefinition[]
     */
    private $fields;

    /**
     * FieldsGroup constructor.
     * @param I18nInterface $label
     * @param FieldDefinition[] $fields
     */
    public function __construct(I18nInterface $label, array $fields)
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
     * @return I18nInterface
     */
    public function getLabel(): I18nInterface
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

    public function toArray(string $name): array
    {
        $array = [
            'name' => $name,
            'label' => $this->label->get(),
            'fields' => [],
        ];
        foreach ($this->getFields() as $fieldName => $fieldDefinition) {
            $array['fields'][$fieldName] = $fieldDefinition->toArray($fieldName);
        }

        return $array;
    }

}