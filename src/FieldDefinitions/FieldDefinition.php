<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 15:33
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


use JsonSerializable;

abstract class FieldDefinition implements JsonSerializable
{

    /** @var string */
    protected $title;

    /** @var string|null*/
    protected $description;

    /** @var callable */
    protected $validator;

    /** @var null */
    protected $default;

    /**
     * ConfigDefinition constructor.
     * @param string $title
     * @param string|null $description
     * @param callable $validator
     * @param null $default
     */
    public function __construct(string $title, ?string $description, callable $validator, $default = null)
    {
        $this->title = $title;
        $this->description = $description;

        $this->validator = $validator;
        $this->default = $default;
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
     * @param $value
     * @return bool errors
     */
    public function validate($value): bool
    {
        return empty(($this->validator)($value));
    }

    public function getErrors($value): array
    {
        return ($this->validator)($value);
    }

    /**
     * @return mixed|null
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return string
     */
    abstract public function getDefinition(): string;

    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'definition' => $this->getDefinition(),
            'default' => $this->getDefault(),
        ];
    }

}