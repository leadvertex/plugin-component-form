<?php
/**
 * Created for plugin-component-form
 * Date: 04.02.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;

use Leadvertex\Plugin\Components\Form\FieldDefinitionTestCase;

class PasswordDefinitionTest extends FieldDefinitionTestCase
{

    protected function getClass(): string
    {
        return PasswordDefinition::class;
    }

    protected function getDefinitionString(): string
    {
        return 'password';
    }
}
