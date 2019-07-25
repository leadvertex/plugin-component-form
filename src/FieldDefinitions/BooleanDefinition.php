<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 16:52
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Form\FieldDefinitions;


class BooleanDefinition extends FieldDefinition
{

    /**
     * @return string
     */
    public function definition(): string
    {
        return 'boolean';
    }

    /**
     * @param bool $value
     * @return bool
     */
    public function validateValue($value): bool
    {
        return is_bool($value) && ($this->required === false || $value === true);
    }
}