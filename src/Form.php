<?php
/**
 * Created for plugin-form
 * Datetime: 02.07.2018 16:59
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme;


use Leadvertex\Plugin\Scheme\Components\i18n;
use TypeError;

class Form
{

    /** @var i18n  */
    protected $name;

    /** @var i18n  */
    protected $description;

    /** @var FieldGroup[] */
    protected $groups = [];

    /** @var FormData */
    protected $data;

    /**
     * Scheme constructor.
     * @param i18n $name
     * @param i18n $description
     * @param FieldGroup[] $fieldGroups
     */
    public function __construct(i18n $name, i18n $description, array $fieldGroups)
    {
        $this->name = $name;
        $this->description = $description;

        foreach ($fieldGroups as $groupName => $fieldsGroup) {
            if (!$fieldsGroup instanceof FieldGroup) {
                throw new TypeError('Every item of $fieldsDefinitions should be instance of ' . FieldGroup::class);
            }
            $this->groups[$groupName] = $fieldsGroup;
        }
    }

    /**
     * Return property name in passed language. If passed language was not defined, will return name in default language
     * @return i18n
     */
    public function getName(): i18n
    {
        return $this->name;
    }

    /**
     * Return property description in passed language. If passed language was not defined, will return description in default language
     * @return i18n
     */
    public function getDescription(): i18n
    {
        return $this->description;
    }

    /**
     * @param string $name
     * @return FieldGroup
     */
    public function getGroup(string $name): FieldGroup
    {
        return $this->groups[$name];
    }

    /**
     * @return FieldGroup[]
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    public function validateData(FormData $formData): bool
    {
        foreach ($formData as $groupName => $fields) {
            if (!array_key_exists($groupName, $this->groups)) {
                return false;
            }

            $group = $this->groups[$groupName];
            foreach ($fields as $fieldName => $value) {
                if (!array_key_exists($fieldName, $group->getFields())) {
                    return false;
                }
            }
        }

        foreach ($this->groups as $groupName => $group) {
            foreach ($group->getFields() as $fieldName => $field) {
                $path = "{$groupName}.{$fieldName}";
                $value = $formData->get($path, $field->getDefaultValue());
                if (!$field->validateValue($value)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @return FormData
     */
    public function getData(): FormData
    {
        return $this->data;
    }

    /**
     * @param FormData $formData
     * @return bool
     */
    public function setData(FormData $formData): bool
    {
        if (!$this->validateData($formData)) {
            return false;
        }

        foreach ($this->groups as $groupName => $group) {
            foreach ($group->getFields() as $fieldName => $field) {
                $path = "{$groupName}.{$fieldName}";
                if (!$formData->has($path)) {
                    $formData->set($path, $field->getDefaultValue());
                }
            }
        }

        $this->data = $formData;
        return true;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'name' => $this->name->toArray(),
            'description' => $this->description->toArray(),
            'groups' => [],
            'languages' => i18n::getLanguageList(),
        ];

        foreach ($this->groups as $groupName => $fieldDefinition) {
            $array['groups'][$groupName] = $fieldDefinition->toArray($groupName);
        }

        return $array;
    }

}