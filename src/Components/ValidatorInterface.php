<?php
/**
 * Created for plugin-component-form
 * Date: 28.12.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\Components;


use Leadvertex\Plugin\Components\Form\FieldDefinitions\FieldDefinition;
use Leadvertex\Plugin\Components\Form\FormData;

interface ValidatorInterface
{

    public function __invoke($value, FieldDefinition $definition, FormData $data): array;

}