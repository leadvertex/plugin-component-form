<?php

namespace Leadvertex\Plugin\Scheme;


use Exception;
use Leadvertex\Plugin\Scheme\Components\Lang;
use Leadvertex\Plugin\Scheme\Components\i18n;
use Leadvertex\Plugin\Scheme\FieldDefinitions\IntegerDefinition;
use Leadvertex\Plugin\Scheme\FieldDefinitions\StringDefinition;
use PHPUnit\Framework\TestCase;
use TypeError;

class SchemeTest extends TestCase
{
    /** @var Developer */
    private $developer;

    /** @var FieldGroup[] */
    private $fieldGroups;

    /** @var Scheme */
    private $scheme;

    /** @var i18n */
    private $label;

    /** @var i18n */
    private $description;

    /** @var i18n */
    private $defaultMultiLang;

    /**
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();

        $this->developer = new Developer(
            'Tony Stark',
            'tony@starkindustries.com',
            'starkindustries.com'
        );

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
                    'field_3' => new IntegerDefinition($this->defaultMultiLang, $this->defaultMultiLang, 1, true),
                    'field_4' => new StringDefinition($this->defaultMultiLang, $this->defaultMultiLang, 'default value for test', true),
                ]
            ),
        ];

        $this->scheme = new Scheme(
            $this->developer,
            $this->label,
            $this->description,
            $this->fieldGroups
        );

    }

    public function testCreateWithNotFieldGroupType()
    {
        $this->expectException(TypeError::class);
        $fieldGroups = [5, 10];
        new Scheme(
            $this->developer,
            $this->label,
            $this->description,
            $fieldGroups
        );
    }

    public function testGetFields()
    {
        $this->assertEquals($this->fieldGroups, $this->scheme->getGroups());
    }

    public function testGetDeveloper()
    {
        $this->assertEquals($this->developer, $this->scheme->getDeveloper());
    }

    public function testGetDescription()
    {
        $this->assertEquals($this->description, $this->scheme->getDescription());
    }

    public function testToArray()
    {
        $expected = [
            'developer' => $this->developer->toArray(),
            'name' => $this->label->toArray(),
            'description' => $this->description->toArray(),
            'groups' => [],
            'languages' => ['en', 'ru'],
        ];
        foreach ($this->fieldGroups as $groupName => $fieldGroup) {
            $expected['groups'][$groupName] = $fieldGroup->toArray();
        }

        $this->assertEquals($expected, $this->scheme->toArray());
    }

    public function testGetGroup()
    {
        $this->assertEquals(
            $this->fieldGroups['main'],
            $this->scheme->getGroup('main')
        );

        $this->assertEquals(
            $this->fieldGroups['additional'],
            $this->scheme->getGroup('additional')
        );
    }

    public function testGetGroups()
    {
        $this->assertEquals($this->fieldGroups, $this->scheme->getGroups());
    }

    public function testGetName()
    {
        $this->assertEquals($this->label, $this->scheme->getName());
    }
}
