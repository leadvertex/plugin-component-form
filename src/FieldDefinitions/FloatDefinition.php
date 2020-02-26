<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 16:54
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


class FloatDefinition extends FieldDefinition
{

    /**
     * @return string
     */
    public function getDefinition(): string
    {
        return 'float';
    }
}