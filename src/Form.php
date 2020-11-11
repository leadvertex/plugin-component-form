<?php
/**
 * Created for plugin-form
 * Datetime: 02.07.2018 16:59
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form;


use JsonSerializable;
use TypeError;

class Form implements JsonSerializable
{

    /** @var string */
    protected $title;

    /** @var string|null*/
    protected $description;

    /** @var FieldGroup[] */
    protected $groups = [];

    /** @var string */
    private $button;

    /**
     * Scheme constructor.
     * @param string $title
     * @param string|null $description
     * @param FieldGroup[] $fieldGroups
     * @param string $button
     */
    public function __construct(string $title, ?string $description, array $fieldGroups, string $button)
    {
        $this->title = $title;
        $this->description = $description;

        foreach ($fieldGroups as $groupName => $fieldsGroup) {
            if (!$fieldsGroup instanceof FieldGroup) {
                throw new TypeError('Every item of $fieldsDefinitions should be instance of ' . FieldGroup::class);
            }
            $this->groups[$groupName] = $fieldsGroup;
        }

        $this->button = $button;
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
     * @return string
     */
    public function getButton(): string
    {
        return $this->button;
    }

    /**
     * @return FormData
     */
    public function getDefaultData(): FormData
    {
        $data = [];
        foreach ($this->groups as $groupName => $group) {
            foreach ($group->getFields() as $fieldName => $field) {
                $data[$groupName][$fieldName] = $field->getDefault();
            }
        }
        return new FormData($data);
    }

    public function validateData(FormData $formData): bool
    {
        foreach ($this->groups as $groupName => $group) {
            foreach ($group->getFields() as $fieldName => $field) {
                $path = "{$groupName}.{$fieldName}";
                $value = $formData->get($path);
                if (!$field->validate($value, $formData)) {
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
                $value = $formData->get($path);
                $error = $field->getErrors($value, $formData);
                if (!empty($error)) {
                    $errors[$groupName][$fieldName] = $error;
                }
            }
        }
        return $errors;
    }

    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'groups' => $this->getGroups(),
            'button' => $this->getButton(),
        ];
    }
}