<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 16:53
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Form\FieldDefinitions;


use Leadvertex\Plugin\I18n\I18nInterface;

class IntegerDefinition extends FieldDefinition
{

    public function __construct(I18nInterface $label, I18nInterface $description, $default, bool $required)
    {
        $default = (int) $default;
        parent::__construct($label, $description, $default, $required);
    }

    /**
     * @return string
     */
    public function definition(): string
    {
        return 'integer';
    }

    /**
     * @param int $value
     * @return bool
     */
    public function validateValue($value): bool
    {
        if (!$this->isRequired() && is_null($value)) {
            return true;
        }

        return is_int($value);
    }
}