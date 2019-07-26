<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 16:54
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


use Leadvertex\Plugin\Components\I18n\I18nInterface;

class FloatDefinition extends FieldDefinition
{

    public function __construct(I18nInterface $label, I18nInterface $description, $default, bool $required)
    {
        $default = (float) $default;
        parent::__construct($label, $description, $default, $required);
    }

    /**
     * @return string
     */
    public function definition(): string
    {
        return 'float';
    }

    /**
     * @param float|int $value
     * @return bool
     */
    public function validateValue($value): bool
    {
        if ($this->isRequired() && is_null($value)) {
            return false;
        }

        return is_numeric($value);
    }
}