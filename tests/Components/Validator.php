<?php
/**
 * Created for plugin-component-form
 * Date: 28.12.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\Components;


use Leadvertex\Plugin\Components\Form\FieldDefinitions\FieldDefinition;
use Leadvertex\Plugin\Components\Form\FormData;

class Validator implements ValidatorInterface
{

    private $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function __invoke($value, FieldDefinition $definition, FormData $data): array
    {
        return ($this->callable)($value, $definition, $data);
    }

}