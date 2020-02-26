<?php
/**
 * Created for plugin-component-form
 * Date: 04.02.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class StaticValuesTest extends TestCase
{

    public function testGet()
    {
        $data = [
            'group' => [
                '0' => 'zero',
                '1' => 'one',
                '2' => 'two',
            ],
        ];
        $values = new StaticValues($data);
        $this->assertEquals($data, $values->get());
    }

    public function testConstructWithoutGroups()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(1);
        new StaticValues([
            '0' => 'zero',
            '1' => 'one',
            '2' => 'two',
        ]);
    }

    public function testConstructWithRedundantLevel()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(2);
        new StaticValues([
            '' => [
                '0' => 'zero',
                '1' => 'one',
                '2' => [
                    '0' => 'zero',
                    '1' => 'one',
                    '2' => 'two',
                ],
            ],
        ]);
    }

}
