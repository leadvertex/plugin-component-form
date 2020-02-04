<?php
/**
 * Created for plugin-component-form
 * Datetime: 29.08.2019 12:40
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


class FileDefinition extends FieldDefinition
{

    /**
     * @return string
     */
    public function definition(): string
    {
        return 'file';
    }

}