<?php

namespace Leadvertex\Plugin\Scheme\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Scheme\Components\Lang;
use Leadvertex\Plugin\Scheme\Components\i18n;
use PHPUnit\Framework\TestCase;

class TextDefinitionTest extends TestCase
{

    /** @var i18n */
    private $label;

    /** @var i18n */
    private $description;

    /** @var string */
    private $default;

    /** @var bool */
    private $required;

    /** @var TextDefinition */
    private $textDefinition;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->label = i18n::instance([
            new Lang('en', 'Organization name'),
            new Lang('ru', 'Название организации')
        ]);

        $this->description = i18n::instance([
            new Lang('en', 'Description'),
            new Lang('ru', 'Описание')
        ]);

        $this->default = 'Test value for default param';
        $this->required = true;

        $this->textDefinition = new TextDefinition(
            $this->label,
            $this->description,
            $this->default,
            $this->required
        );

    }

    public function testDefinition()
    {
        $this->assertEquals('text', $this->textDefinition->definition());
    }

}
