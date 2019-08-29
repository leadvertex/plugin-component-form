<?php
/**
 * Created for plugin-component-form
 * Datetime: 29.08.2019 12:45
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;

use Exception;
use Leadvertex\Plugin\Components\Form\I18n;
use Leadvertex\Plugin\Components\I18n\I18nInterface;
use PHPUnit\Framework\TestCase;

class FileDefinitionTest extends TestCase
{
    /** @var I18nInterface */
    private $label;

    /** @var I18nInterface */
    private $description;

    /** @var string */
    private $default;

    /** @var bool */
    private $required;

    /** @var FileDefinition */
    private $definition;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->label = new I18n('Organization name', 'Название организации');
        $this->description = new I18n('Description', 'Описание');

        $this->default = 'Test value for default param';
        $this->required = true;

        $this->definition = new FileDefinition(
            $this->label,
            $this->description,
            $this->default,
            $this->required
        );

    }

    public function testDefinition()
    {
        $this->assertEquals('file', $this->definition->definition());
    }

    /**
     * @dataProvider dataProviderForValidate
     * @param bool $required
     * @param string $value
     * @param bool $expected
     * @throws Exception
     */
    public function testValidateValue(bool $required, $value, bool $expected)
    {
        $stringDefinition = new FileDefinition(
            $this->label,
            $this->description,
            $this->default,
            $required
        );

        $this->assertEquals($expected, $stringDefinition->validateValue($value));
    }

    public function dataProviderForValidate()
    {
        return [
            [
                'required' => true,
                'value' => '   ',
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => 'notEmpty',
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => 1,
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => [],
                'expected' => false,
            ],
            [
                'required' => true,
                'value' => 'http://example.com',
                'expected' => true,
            ],

            [
                'required' => false,
                'value' => '   ',
                'expected' => false,
            ],
            [
                'required' => false,
                'value' => 'notEmpty',
                'expected' => false,
            ],
            [
                'required' => false,
                'value' => 1,
                'expected' => false,
            ],
            [
                'required' => false,
                'value' => 'http://example.com',
                'expected' => true,
            ],
        ];
    }
}
