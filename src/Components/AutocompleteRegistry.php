<?php
/**
 * Created for plugin-component-form
 * Date: 30.11.2020
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Components\Form\Components;


use RuntimeException;

final class AutocompleteRegistry
{

    /** @var callable */
    private static $resolver;

    private function __construct() {}

    public static function config(callable $resolver): void
    {
        self::$resolver = $resolver;
    }

    public static function getAutocomplete(string $name): ?AutocompleteInterface
    {
        if (!isset(self::$resolver)) {
            throw new RuntimeException('Autocomplete registry was not configured');
        }

        $resolver = self::$resolver;
        return $resolver($name);
    }

}