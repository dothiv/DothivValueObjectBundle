<?php

namespace Dothiv\ValueObject;

use JMS\Serializer\Annotation as Serializer;

/**
 * The clock service abstracts the current date.
 */
class ClockValue extends AbstractValueObject implements ValueObjectInterface
{

    /**
     * @var \DateTime
     */
    private $clock;

    /**
     * @param string $clockExpr
     */
    public function __construct($clockExpr)
    {
        $this->clock = $clockExpr instanceof \DateTime ? $clockExpr : new \DateTime($clockExpr);
    }

    /**
     * @return \DateTime
     */
    public function getNow()
    {
        return clone $this->clock;
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
     * @Serializer\HandlerCallback("json", direction = "serialization")
     */
    public function __toString()
    {
        return $this->clock->format(DATE_W3C);
    }

}
