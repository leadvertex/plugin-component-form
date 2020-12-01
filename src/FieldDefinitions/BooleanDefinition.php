<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 16:52
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


class BooleanDefinition extends FieldDefinition
{

    public function getDefinition(): string
    {
        return 'boolean';
    }
}