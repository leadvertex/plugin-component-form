<?php
/**
 * Created for plugin-form
 * Datetime: 02.07.2018 16:59
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form;


use InvalidArgumentException;
use JsonSerializable;
use TypeError;

class Form implements JsonSerializable
{

    /** @var string|callable */
    protected $title;

    /** @var string|callable|null*/
    protected $description;

    /** @var FieldGroup[]|callable */
    protected $groups = [];

    /** @var string|callable */
    private $button;

    /**
     * Scheme constructor.
     * @param string|callable $title
     * @param string|callable|null $description
     * @param FieldGroup[]|callable $fieldGroups
     * @param string|callable $button
     */
    public function __construct($title, $description, $fieldGroups, $button)
    {
        $this->title = $title;
        $this->description = $description;

        if (is_array($fieldGroups)) {
            foreach ($fieldGroups as $groupName => $fieldsGroup) {
                if (!$fieldsGroup instanceof FieldGroup) {
                    throw new TypeError('Every item of $fieldsDefinitions should be instance of ' . FieldGroup::class);
                }
                $this->groups[$groupName] = $fieldsGroup;
            }
        } elseif (is_callable($fieldGroups)) {
            $this->groups = $fieldGroups;
        } else {
            throw new InvalidArgumentException('Argument "$fieldGroups" should be array or callable');
        }

        $this->button = $button;
    }

    public function getTitle(): string
    {
        return is_callable($this->title) ? ($this->title)() : $this->title;
    }

    public function getDescription(): ?string
    {
        return is_callable($this->description) ? ($this->description)() : $this->description;
    }

    /**
     * @return FieldGroup[]
     */
    public function getGroups(): array
    {
        return is_callable($this->groups) ? ($this->groups)() : $this->groups;
    }

    public function getButton(): string
    {
        return is_callable($this->button) ? ($this->button)() : $this->button;
    }

    public function getDefaultData(): FormData
    {
        $data = [];
        foreach ($this->getGroups() as $groupName => $group) {
            foreach ($group->getFields() as $fieldName => $field) {
                $data[$groupName][$fieldName] = $field->getDefault();
            }
        }
        return new FormData($data);
    }

    public function validateData(FormData $formData): bool
    {
        foreach ($this->getGroups() as $groupName => $group) {
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
        foreach ($this->getGroups() as $groupName => $group) {
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