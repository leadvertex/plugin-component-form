<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 15:37
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


use Leadvertex\Plugin\Components\I18n\I18nInterface;

class PasswordDefinition extends FieldDefinition
{

    public function __construct(I18nInterface $label, I18nInterface $description, $default, bool $required)
    {
        $default = (string) $default;
        parent::__construct($label, $description, $default, $required);
    }

    /**
     * @return string
     */
    public function definition(): string
    {
        return 'password';
    }

    /**
     * @param string $value
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

        return is_string($value);
    }
}