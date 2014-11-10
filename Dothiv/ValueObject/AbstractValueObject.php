<?php


namespace Dothiv\ValueObject;

abstract class AbstractValueObject implements ValueObjectInterface
{
    /**
     * {@inheritdoc}
     */
    public function equals(ValueObjectInterface $compare)
    {
        if (get_class($this) !== get_class($compare)) {
            return false;
        }
        if ($this->toScalar() !== $compare->toScalar()) {
            return false;
        }
        return true;
    }
}
