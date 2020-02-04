<?php
/**
 * Created for plugin-component-form
 * Date: 04.02.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values;

use PHPUnit\Framework\TestCase;

class DynamicValuesTest extends TestCase
{

    public function testGet()
    {
        $url = 'https://example.com/';
        $values = new DynamicValues($url);
        $this->assertEquals($url, $values->get());
    }

}
