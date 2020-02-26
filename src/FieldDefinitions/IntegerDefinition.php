<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 16:53
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;

class IntegerDefinition extends FieldDefinition
{

    /**
     * @return string
     */
    public function getDefinition(): string
    {
        return 'integer';
    }

}