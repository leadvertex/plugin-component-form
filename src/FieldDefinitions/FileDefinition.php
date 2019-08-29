<?php
/**
 * Created for plugin-component-form
 * Datetime: 29.08.2019 12:40
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


class FileDefinition extends FieldDefinition
{

    /**
     * @return string
     */
    public function definition(): string
    {
        return 'file';
    }

    /**
     * @param $value
     * @return bool
     */
    public function validateValue($value): bool
    {
        if (is_string($value)) {
            $value = trim($value);
        }

        $isEmpty = is_null($value) || (is_string($value) && empty($value));
        if ($this->isRequired() && $isEmpty) {
            return false;
        }

        return $validUrl = filter_var($value, FILTER_VALIDATE_URL);
    }
}