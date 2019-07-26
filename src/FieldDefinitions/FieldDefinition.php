<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 15:33
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Components\I18n\I18nInterface;

abstract class FieldDefinition
{

    protected $label = [];
    protected $description = [];
    protected $default;
    protected $required;

    /**
     * ConfigDefinition constructor.
     * @param I18nInterface $label
     * @param I18nInterface $description
     * @param string|int|float|bool|array|null $default value
     * @param bool $required is this field required
     * @throws Exception
     */
    public function __construct(I18nInterface $label, I18nInterface $description, $default, bool $required)
    {
        $this->label = $label;
        $this->description = $description;
        $this->default = $default;
        $this->required = $required;
    }

        /**
     * Value, witch will be used as default
     * @return string|int|float|bool|array|null
     */
    public function getDefaultValue()
    {
        return $this->default;
    }

    /**
     * Does this field will be required
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @return string
     */
    abstract public function definition(): string;

    /**
     * @param $value
     * @return bool
     */
    abstract public function validateValue($value): bool;

    public function toArray(string $name): array
    {
        return [
            'name' => $name,
            'definition' => $this->definition(),
            'label' => $this->label->get(),
            'description' => $this->description->get(),
            'default' => $this->default,
            'required' => (bool) $this->required,
        ];
    }

}