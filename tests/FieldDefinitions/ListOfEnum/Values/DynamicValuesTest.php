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
        $uri = 'https://example.com/';
        $values = new DynamicValues($uri);
        $this->assertEquals($uri, $values->get());
    }

    public function testJsonSerialize()
    {
        $uri = 'example.com';
        $this->assertSame(
            "\"{$uri}\"",
            json_encode(new DynamicValues($uri))
        );
    }

}
