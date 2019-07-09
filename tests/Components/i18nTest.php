<?php
/**
 * Created for plugin-scheme
 * Datetime: 08.07.2019 16:35
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme\Components;

use Leadvertex\Plugin\Scheme\Exceptions\TranslationException;
use PHPUnit\Framework\TestCase;

class i18nTest extends TestCase
{

    /** @var Lang */
    private $en;

    /** @var Lang */
    private $ru;

    /** @var Lang */
    private $es;

    /** @var i18n */
    private $translation;

    protected function setUp()
    {
        parent::setUp();
        $this->en = new Lang('en', 'Language');
        $this->ru = new Lang('ru', 'Язык');
        $this->es = new Lang('es', 'Idioma');
        $this->translation = i18n::instance([$this->ru, $this->en]);
    }

    public function testInstance()
    {
        $this->assertInstanceOf(
            i18n::class,
            i18n::instance([$this->ru, $this->en])
        );
    }

    public function testOtherSortingInstance()
    {
        $this->assertInstanceOf(
            i18n::class,
            i18n::instance([$this->en, $this->ru])
        );
    }

    public function testNotAllLanguagesInstance()
    {
        $this->expectException(TranslationException::class);
        i18n::instance([$this->en]);
    }

    public function testOverallLanguagesInstance()
    {
        $this->expectException(TranslationException::class);
        i18n::instance([$this->en, $this->ru, $this->es]);
    }

    public function testToArray()
    {
        $this->assertSame([
            'ru' => [
                'language' => 'ru',
                'text' => 'Язык',
            ],
            'en' => [
                'language' => 'en',
                'text' => 'Language',
            ],
        ], $this->translation->toArray());
    }

    public function testGetLanguageList()
    {
        $this->assertEquals(['en', 'ru'], i18n::getLanguageList());
    }
}
