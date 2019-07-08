<?php
/**
 * Created for plugin-scheme
 * Datetime: 08.07.2019 16:10
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme\Components;

use PHPUnit\Framework\TestCase;

class LangTest extends TestCase
{

    /** @var Lang */
    private $language;

    protected function setUp()
    {
        parent::setUp();
        $this->language = new Lang('en', 'Use headers');
    }

    public function testGetLanguage()
    {
        $this->assertEquals('en', $this->language->getLanguage());
    }

    public function testGetText()
    {
        $this->assertEquals('Use headers', $this->language->getText());
    }
}
