<?php
/**
 * Created for plugin-export-core
 * Datetime: 04.07.2019 16:49
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme;

use Leadvertex\Plugin\Scheme\Components\Lang;
use Leadvertex\Plugin\Scheme\Components\i18n;
use Leadvertex\Plugin\Scheme\FieldDefinitions\BooleanDefinition;
use Leadvertex\Plugin\Scheme\FieldDefinitions\FieldDefinition;
use PHPUnit\Framework\TestCase;
use TypeError;

class FieldGroupTest extends TestCase
{

    /** @var i18n */
    private $label;

    /** @var FieldDefinition[] */
    private $fields;

    /** @var FieldGroup */
    private $group;

    protected function setUp()
    {
        parent::setUp();

        $this->label = i18n::instance([
            new Lang('en', 'Main settings'),
            new Lang('ru', 'Основные настройки'),
        ]);

        $this->fields = [
            'use' => new BooleanDefinition(
                i18n::instance([
                    new Lang('en', 'Use this format'),
                    new Lang('ru', 'Использовать этот формат'),
                ]),
                i18n::instance([
                    new Lang('en', 'Include this type in export'),
                    new Lang('ru', 'Включать этот тип в выгрузку'),
                ]),
                true,
                false
            ),
            'printCaption' => new BooleanDefinition(
                i18n::instance([
                    new Lang('en', 'Print caption'),
                    new Lang('ru', 'Печатать заголовок'),
                ]),
                i18n::instance([
                    new Lang('en', 'Print caption at first page'),
                    new Lang('ru', 'Печатает заголовок на первой странице'),
                ]),
                true,
                false
            ),
        ];

        $this->group = new FieldGroup($this->label, $this->fields);
    }

    public function testCreateWithNotFieldGroupType()
    {
        $this->expectException(TypeError::class);
        new FieldGroup($this->label, [1, 2]);
    }

    public function testGetLabel()
    {
        $this->assertEquals($this->label, $this->group->getLabel());
    }

    public function testGetField()
    {
        $this->assertEquals(
            $this->fields['use'],
            $this->group->getField('use')
        );
    }

    public function testGetFields()
    {
        $this->assertEquals($this->fields, $this->group->getFields());
    }

    public function testToArray()
    {
        $this->assertEquals([
            'name' => 'Field name',
            'label' => $this->label->toArray(),
            'fields' => [
                'use' => $this->fields['use']->toArray('use'),
                'printCaption' => $this->fields['printCaption']->toArray('printCaption'),
            ],
        ], $this->group->toArray('Field name'));
    }

}
