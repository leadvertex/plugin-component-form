<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 15:37
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


class StringDefinition extends FieldDefinition
{

    /**
     * @return string
     */
    public function getDefinition(): string
    {
        return 'string';
    }
}