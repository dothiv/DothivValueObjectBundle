<?php

namespace Dothiv\ValueObject;

use Dothiv\ValueObject\Exception\InvalidArgumentException;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class TwitterHandleValue implements StringValue
{

    /**
     * @var string
     */
    private $handle;

    /**
     * @param string $handle
     *
     * @throws InvalidArgumentException If an invalid url is provided.
     */
    public function __construct($handle)
    {
        if ($handle instanceof TwitterHandleValue) {
            $this->handle = (string)$handle;
            return;
        }

        $handle = trim($handle);
        $regexp = "/^@[a-zA-Z0-9_]{1,15}$/";
        if (!preg_match($regexp, $handle)) {
            throw new InvalidArgumentException(sprintf('Invalid twitter handle provided: "%s"!', $handle));
        }

        $this->handle = $handle;
    }

    /**
     * Static constructor.
     *
     * @param string $handle
     *
     * @return TwitterHandleValue
     */
    public static function create($handle)
    {
        $c = __CLASS__;
        return new $c($handle);
    }

    /**
     * Converts the value to a string.
     *
     * @return string
     * @Serializer\HandlerCallback("json", direction = "serialization")
     */
    public function __toString()
    {
        return $this->handle;
    }
} 
