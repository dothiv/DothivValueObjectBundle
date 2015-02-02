<?php

namespace Dothiv\ValueObject;

/**
 * This value will return null, if an empty (as in empty()) value is given to it.
 */
class NullOnEmptyValue extends AbstractValueObject implements ValueObjectInterface
{
    /**
     * @param mixed|null $value
     */
    public function __construct($value = null)
    {
        if (is_string($value)) {
            $value = trim($value);
        }
        $this->value = empty($value) ? null : $value;
    }

    /**
     * @param mixed|null $value
     *
     * @return NullOnEmptyValue
     * @deprecated Use NullOnEmptyValue::create($value)
     */
    public static function parse($value = null)
    {
        return static::create($value);
    }

    /**
     * @param mixed|null $value
     *
     * @return NullOnEmptyValue
     * @since v1.3.1
     */
    public static function create($value = null)
    {
        $class = __CLASS__;
        return new $class($value);
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function toScalar()
    {
        return $this->__toString();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string)$this->value;
    }

}
