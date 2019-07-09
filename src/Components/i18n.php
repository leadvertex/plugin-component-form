<?php
/**
 * Created for plugin-export-core
 * Datetime: 28.06.2019 14:58
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme\Components;


use Leadvertex\Plugin\Scheme\Exceptions\TranslationException;
use TypeError;

class i18n
{

    /**
     * @var array
     */
    private static $usedLanguages = [];

    /**
     * @var Lang[]
     */
    private $languages;

    /**
     * Translation constructor.
     * @param Lang[] $languages
     */
    private function __construct(array $languages)
    {
        $this->languages = $languages;
    }

    public function toArray(): array
    {
        $languages = [];
        foreach ($this->languages as $language) {
            $languages[$language->getLanguage()] = [
                'language' => $language->getLanguage(),
                'text' => $language->getText(),
            ];
        }

        return $languages;
    }

    /**
     * @param Lang[] $languages
     * @return self
     */
    public static function instance(array $languages): self
    {
        $usedLanguages = [];
        foreach ($languages as $language) {
            if (!($language instanceof Lang)) {
                throw new TypeError('Translation should be instance of ' . Lang::class);
            }
            $usedLanguages[$language->getLanguage()] = true;
        }

        if (!empty(self::$usedLanguages) && $usedLanguages != self::$usedLanguages) {
            throw new TranslationException(
                array_keys(self::$usedLanguages),
                array_keys($usedLanguages)
            );
        }

        self::$usedLanguages = array_merge(
            self::$usedLanguages,
            $usedLanguages
        );

        ksort(self::$usedLanguages);

        return new self($languages);
    }

    public static function getLanguageList(): array
    {
        return array_keys(self::$usedLanguages);
    }

}