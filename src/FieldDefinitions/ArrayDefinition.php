<?php
/**
 * Created for plugin-form.
 * Datetime: 02.07.2018 15:37
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Components\Form\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Components\I18n\I18nInterface;

class ArrayDefinition extends FieldDefinition
{

    use GuardEnumTrait;

    /**
     * @var I18nInterface[]
     */
    protected $enum;

    /**
     * ArrayDefinition constructor.
     * @param I18nInterface $label
     * @param I18nInterface $description
     * @param I18nInterface[] $enum witch represent value => caption dropdown in different languages
     * array(
     *  'jan' => new MultiLang('en' => 'January', 'ru' => 'Январь'),
     *  'feb' => new MultiLang('en' => 'February', 'ru' => 'Февраль'),
     * )
     * @param $default
     * @param bool $required
     * @throws Exception
     */
    public function __construct(I18nInterface $label, I18nInterface $description, array $enum, $default, bool $required)
    {
        parent::__construct($label, $description, $default, $required);
        $this->guardEnumI18n($enum);
        $this->enum = $enum;
    }

    /**
     * @return string
     */
    public function definition(): string
    {
        return 'array';
    }

    /**
     * @param $array
     * @return bool
     */
    public function validateValue($array): bool
    {
        $isEmpty = is_null($array) || (is_array($array) && empty($array));
        if ($this->isRequired() && $isEmpty) {
            return false;
        }

        $isFlatArray = is_array($array) && (count($array) !== count($array, COUNT_RECURSIVE));
        if ($isFlatArray) {
            return false;
        }

        //Invalid values
        foreach ($array as $value) {
            if (!isset($this->enum[$value])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function getEnum(): array
    {
        return $this->enum;
    }

    public function toArray(string $name): array
    {
        $array = parent::toArray($name);
        foreach ($this->enum as $value => $I18nInterface) {
            $array['enum'][$value] = [
                'value' => $value,
                'label' => $I18nInterface->get(),
            ];
        }
        return $array;
    }
}