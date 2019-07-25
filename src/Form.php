<?php
/**
 * Created for plugin-form
 * Datetime: 02.07.2018 16:59
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Form;


use Leadvertex\Plugin\I18n\I18nInterface;
use TypeError;

class Form
{

    /** @var I18nInterface  */
    protected $name;

    /** @var I18nInterface  */
    protected $description;

    /** @var FieldGroup[] */
    protected $groups = [];

    /** @var FormData */
    protected $data;

    /**
     * Scheme constructor.
     * @param I18nInterface $name
     * @param I18nInterface $description
     * @param FieldGroup[] $fieldGroups
     */
    public function __construct(I18nInterface $name, I18nInterface $description, array $fieldGroups)
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
     * @return I18nInterface
     */
    public function getName(): I18nInterface
    {
        return $this->name;
    }

    /**
     * Return property description in passed language. If passed language was not defined, will return description in default language
     * @return I18nInterface
     */
    public function getDescription(): I18nInterface
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
            'name' => $this->name->get(),
            'description' => $this->description->get(),
            'groups' => [],
        ];

        foreach ($this->groups as $groupName => $fieldDefinition) {
            $array['groups'][$groupName] = $fieldDefinition->toArray($groupName);
        }

        return $array;
    }

}