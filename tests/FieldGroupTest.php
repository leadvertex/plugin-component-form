<?php
/**
 * Created for plugin-form
 * Datetime: 04.07.2019 16:49
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Form;

use Leadvertex\Plugin\Form\FieldDefinitions\BooleanDefinition;
use Leadvertex\Plugin\Form\FieldDefinitions\FieldDefinition;
use Leadvertex\Plugin\I18n\I18nInterface;
use PHPUnit\Framework\TestCase;
use TypeError;

class FieldGroupTest extends TestCase
{

    /** @var I18nInterface */
    private $label;

    /** @var FieldDefinition[] */
    private $fields;

    /** @var FieldGroup */
    private $group;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label = new I18n('Main settings', 'Основные настройки');

        $this->fields = [
            'use' => new BooleanDefinition(
                new I18n('Use this format', 'Использовать этот формат'),
                new I18n('Include this type in export', 'Включать этот тип в выгрузку'),
                true,
                false
            ),
            'printCaption' => new BooleanDefinition(
                new I18n('Print caption', 'Печатать заголовок'),
                new I18n('Print caption at first page', 'Печатает заголовок на первой странице'),
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
            'label' => $this->label->get(),
            'fields' => [
                'use' => $this->fields['use']->toArray('use'),
                'printCaption' => $this->fields['printCaption']->toArray('printCaption'),
            ],
        ], $this->group->toArray('Field name'));
    }

}
