<?php
/**
 * Created for plugin-export-core.
 * Datetime: 02.07.2018 16:07
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Scheme\FieldDefinitions;


use Exception;
use Leadvertex\Plugin\Scheme\Components\i18n;

class EnumDefinition extends FieldDefinition
{

    use GuardEnumTrait;

    protected $enum;

    /**
     * ConfigDefinition constructor.
     * @param i18n $label
     * @param i18n $description
     * @param i18n[] $enum witch represent value => caption dropdown in different languages
     * array(
     *  '01' => new MultiLang('en' => 'January', 'ru' => 'Январь'),
     *  '02' => new MultiLang('en' => 'February', 'ru' => 'Февраль'),
     * )
     * @param string|int|float|bool|null $default value
     * @param bool $required is this field required
     * @throws Exception
     */
    public function __construct(i18n $label, i18n $description, array $enum, $default, bool $required)
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
        return 'enum';
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        foreach ($this->enum as $name => $i18n) {
            $array['enum'][$name] = $i18n->toArray();
        }
        return $array;
    }

    /**
     * @param string|int|float|null $value
     * @return bool
     */
    public function validateValue($value): bool
    {
        if ($this->isRequired() && is_null($value)) {
            return false;
        }

        return isset($this->enum[$value]);
    }
}