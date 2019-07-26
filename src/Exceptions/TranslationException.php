<?php
/**
 * Created for plugin-form
 * Datetime: 08.07.2019 15:49
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\Exceptions;


use LogicException;

class TranslationException extends LogicException
{

    public function __construct(array $expected, array $actual)
    {
        $expectedImplode = implode(', ', $expected);
        $actualImplode = implode(', ', $actual);
        $message = "Invalid translation array. Expected: '{$expectedImplode}', actual: '{$actualImplode}'";
        parent::__construct($message);
    }

}