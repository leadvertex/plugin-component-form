<?php
/**
 * Created for plugin-export-core.
 * Datetime: 02.07.2018 16:54
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme\FieldDefinitions;


use Leadvertex\Plugin\Scheme\Components\i18n;

class FloatDefinition extends FieldDefinition
{

    public function __construct(i18n $label, i18n $description, $default, bool $required)
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