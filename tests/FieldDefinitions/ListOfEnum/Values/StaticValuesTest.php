<?php
/**
 * Created for plugin-component-form
 * Date: 04.02.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values;

use PHPUnit\Framework\TestCase;

class StaticValuesTest extends TestCase
{

    public function testGet()
    {
        $data = [
            '0' => 'zero',
            '1' => 'one',
            '2' => 'two',
        ];
        $values = new StaticValues($data);
        $this->assertEquals($data, $values->get());
    }

}
