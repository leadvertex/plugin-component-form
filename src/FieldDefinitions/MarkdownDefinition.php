<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 16:07
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


class MarkdownDefinition extends StringDefinition
{

    public function getDefinition(): string
    {
        return 'markdown';
    }
}