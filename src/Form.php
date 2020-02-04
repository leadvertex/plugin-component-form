<?php
/**
 * Created for plugin-form
 * Datetime: 02.07.2018 16:59
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form;


use TypeError;

class Form
{

    /** @var string */
    protected $title;

    /** @var string|null*/
    protected $description;

    /** @var FieldGroup[] */
    protected $groups = [];

    /** @var FormData */
    private $data;

    /**
     * Scheme constructor.
     * @param string $title
     * @param string|null $description
     * @param FieldGroup[] $fieldGroups
     */
    public function __construct(string $title, ?string $description, array $fieldGroups)
    {
        $this->title = $title;
        $this->description = $description;

        foreach ($fieldGroups as $groupName => $fieldsGroup) {
            if (!$fieldsGroup instanceof FieldGroup) {
                throw new TypeError('Every item of $fieldsDefinitions should be instance of ' . FieldGroup::class);
            }
            $this->groups[$groupName] = $fieldsGroup;
        }
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return FieldGroup[]
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @return FormData
     */
    public function getData(): FormData
    {
        if (is_null($this->data)) {
            $data = [];
            foreach ($this->groups as $groupName => $group) {
                foreach ($group->getFields() as $fieldName => $field) {
                    $data[$groupName][$fieldName] = $field->getDefault();
                }
            }
            $this->data = new FormData($data);
        }

        return $this->data;
    }

    /**
     * @param FormData $formData
     */
    public function setData(FormData $formData)
    {
        foreach ($this->groups as $groupName => $group) {
            foreach ($group->getFields() as $fieldName => $field) {
                $path = "{$groupName}.{$fieldName}";
                if (!$formData->has($path)) {
                    $formData->set($path, $field->getDefault());
                }
            }
        }

        $this->data = $formData;
    }

    public function validateData(FormData $formData): bool
    {
        foreach ($this->groups as $groupName => $group) {
            foreach ($group->getFields() as $fieldName => $field) {
                $path = "{$groupName}.{$fieldName}";
                $value = $formData->get($path, $field->getDefault());
                if (!$field->validate($value)) {
                    return false;
                }
            }
        }
        return true;
    }

    public function getErrors(FormData $formData): array
    {
        $errors = [];
        foreach ($this->groups as $groupName => $group) {
            foreach ($group->getFields() as $fieldName => $field) {
                $path = "{$groupName}.{$fieldName}";
                $value = $formData->get($path, $field->getDefault());
                $error = $field->getErrors($value);
                if (!empty($error)) {
                    $errors[$groupName][$fieldName] = $error;
                }
            }
        }
        return $errors;
    }

}