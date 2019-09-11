<?php

namespace Leadvertex\Plugin\Components\Form;


use Exception;
use Leadvertex\Plugin\Components\Form\FieldDefinitions\IntegerDefinition;
use Leadvertex\Plugin\Components\Form\FieldDefinitions\StringDefinition;
use Leadvertex\Plugin\Components\I18n\I18nInterface;
use PHPUnit\Framework\TestCase;
use TypeError;

class FormTest extends TestCase
{

    /** @var FieldGroup[] */
    private $fieldGroups;

    /** @var Form */
    private $form;

    /** @var Form */
    private $formNullData;

    /** @var I18nInterface */
    private $label;

    /** @var I18nInterface */
    private $description;

    /** @var I18nInterface */
    private $defaultMultiLang;

    /** @var FormData */
    private $formData;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->label = new I18n('Organization name', 'Название организации');
        $this->description = new I18n('Description', 'Описание');
        $this->defaultMultiLang = new I18n('default test field', 'Дефолтное тестовое поле');

        $this->fieldGroups = [
            'main' => new FieldGroup(
                new I18n('Main settings', 'Основные настройки'),
                [
                    'field_1' => new IntegerDefinition($this->defaultMultiLang, $this->defaultMultiLang, 1, true),
                    'field_2' => new StringDefinition($this->defaultMultiLang, $this->defaultMultiLang, 'default value for test', true),
                ]
            ),
            'additional' => new FieldGroup(
                new I18n('Additional settings', 'Дополнительные настройки'),
                [
                    'field_3' => new IntegerDefinition($this->defaultMultiLang, $this->defaultMultiLang, 3, false),
                    'field_4' => new StringDefinition($this->defaultMultiLang, $this->defaultMultiLang, 'hello kitty', false),
                ]
            ),
        ];

        $this->form = new Form(
            $this->label,
            $this->description,
            $this->fieldGroups
        );

        $this->formNullData = new Form(
            $this->label,
            $this->description,
            $this->fieldGroups
        );

        $this->formData = new FormData([
            'main' => [
                'field_1' => 1,
                'field_2' => 'hello world',
            ]
        ]);

        $this->form->setData($this->formData);
    }

    public function testCreateWithNotFieldGroupType()
    {
        $this->expectException(TypeError::class);
        $fieldGroups = [5, 10];
        new Form(
            $this->label,
            $this->description,
            $fieldGroups
        );
    }

    public function testGetFields()
    {
        $this->assertEquals($this->fieldGroups, $this->form->getGroups());
    }

    public function testGetDescription()
    {
        $this->assertEquals($this->description, $this->form->getDescription());
    }

    public function testToArray()
    {
        $expected = [
            'name' => $this->label->get(),
            'description' => $this->description->get(),
            'groups' => [],
        ];
        foreach ($this->fieldGroups as $groupName => $fieldGroup) {
            $expected['groups'][$groupName] = $fieldGroup->toArray($groupName);
        }

        $this->assertEquals($expected, $this->form->toArray());
    }

    public function testGetGroup()
    {
        $this->assertEquals(
            $this->fieldGroups['main'],
            $this->form->getGroup('main')
        );

        $this->assertEquals(
            $this->fieldGroups['additional'],
            $this->form->getGroup('additional')
        );
    }



    public function testValidateData()
    {
        $this->assertFalse($this->form->validateData(new FormData([
            'main' => [
                'field_1' => 'hello world',
                'field_2' => 'hello world',
                'field_3' => '',
            ],
        ])));

        $this->assertTrue($this->form->validateData(new FormData([
            'main' => [
                'field_1' => 1,
                'field_2' => 'hello world',
                'field_3' => '',
            ],
        ])));

        $this->assertFalse($this->form->validateData(new FormData([
            'main' => [
                'field_1' => null,
                'field_2' => null,
            ],
        ])));

        $this->assertTrue($this->form->validateData(new FormData([
            'main' => [
                'field_1' => 1,
                'field_2' => 'hello world',
            ],
        ])));

        $this->assertTrue($this->form->validateData(new FormData([])));

        $this->assertTrue($this->form->validateData(null));
    }

    public function testGetData()
    {
        $this->assertEquals([
            'main' => [
                'field_1' => 1,
                'field_2' => 'hello world',
            ],
            'additional' => [
                'field_3' => 3,
                'field_4' => 'hello kitty',
            ]
        ], $this->form->getData()->all());
    }

    public function testGetDataFromNull()
    {
        $this->assertEquals([
            'main' => [
                'field_1' => 1,
                'field_2' => 'default value for test',
            ],
            'additional' => [
                'field_3' => 3,
                'field_4' => 'hello kitty',
            ]
        ], $this->formNullData->getData()->all());
    }

    public function testSetData()
    {
        $data = new FormData([
            'main' => [
                'field_1' => 1,
                'field_2' => 'hello world',
            ],
            'additional' => [
                'field_3' => null,
                'field_4' => '',
            ]
        ]);

        $result = $this->form->setData($data);
        $this->assertTrue($result);
        $this->assertEquals($data->all(), $this->form->getData()->all());

        $data = new FormData([
            'main' => [
                'field_1' => 'hello',
                'field_2' => 'hello',
            ],
        ]);
        $result = $this->form->setData($data);
        $this->assertFalse($result);
    }

    public function testGetGroups()
    {
        $this->assertEquals($this->fieldGroups, $this->form->getGroups());
    }

    public function testGetName()
    {
        $this->assertEquals($this->label, $this->form->getName());
    }

}
