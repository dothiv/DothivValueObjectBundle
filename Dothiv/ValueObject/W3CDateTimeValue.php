<?php

namespace Dothiv\ValueObject;

use Dothiv\ValueObject\Exception\InvalidArgumentException;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class W3CDateTimeValue implements ValueObjectInterface
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @param string $date
     *
     * @throws InvalidArgumentException If an invalid url is provided.
     */
    public function __construct($date)
    {
        if ($date instanceof \DateTime) {
            $this->date = $date;
        } else {
            try {
                $this->date = new \DateTime($date);
            } catch (\Exception $e) {
                throw new InvalidArgumentException(sprintf('Invalid date provided: "%s"!', $date));
            }
        }
    }

    /**
     * {@inheritdoc}
     * @Serializer\HandlerCallback("json", direction = "serialization")
     */
    function __toString()
    {
        return $this->date->format(DATE_W3C);
    }

    /**
     * {@inheritdoc}
     */
    public function toScalar()
    {
        return $this->__toString();
    }
} 
