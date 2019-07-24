<?php

namespace Leadvertex\Plugin\Scheme;


use Exception;
use Leadvertex\Plugin\Scheme\Components\Lang;
use Leadvertex\Plugin\Scheme\Components\i18n;
use Leadvertex\Plugin\Scheme\FieldDefinitions\IntegerDefinition;
use Leadvertex\Plugin\Scheme\FieldDefinitions\StringDefinition;
use PHPUnit\Framework\TestCase;
use TypeError;

class FormTest extends TestCase
{

    /** @var FieldGroup[] */
    private $fieldGroups;

    /** @var Form */
    private $form;

    /** @var i18n */
    private $label;

    /** @var i18n */
    private $description;

    /** @var i18n */
    private $defaultMultiLang;

    /** @var FormData */
    private $formData;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->label = i18n::instance([
            new Lang('en', 'Organization name'),
            new Lang('ru', 'Название организации'),
        ]);

        $this->description = i18n::instance([
            new Lang('en', 'Description'),
            new Lang('ru', 'Описание'),
        ]);

        $this->defaultMultiLang = i18n::instance([
            new Lang('en', 'default test field'),
            new Lang('ru', 'Дефолтное тестовое поле'),
        ]);

        $this->fieldGroups = [
            'main' => new FieldGroup(
                i18n::instance([
                    new Lang('en', 'Main settings'),
                    new Lang('ru', 'Основные настройки'),
                ]),
                [
                    'field_1' => new IntegerDefinition($this->defaultMultiLang, $this->defaultMultiLang, 1, true),
                    'field_2' => new StringDefinition($this->defaultMultiLang, $this->defaultMultiLang, 'default value for test', true),
                ]
            ),
            'additional' => new FieldGroup(
                i18n::instance([
                    new Lang('en', 'Additional settings'),
                    new Lang('ru', 'Дополнительные настройки'),
                ]),
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
            'name' => $this->label->toArray(),
            'description' => $this->description->toArray(),
            'groups' => [],
            'languages' => ['en', 'ru'],
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
            'main' => [],
            'additional' => [],
            'extra' => [],
        ])));

        $this->assertFalse($this->form->validateData(new FormData([
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
