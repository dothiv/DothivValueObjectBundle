<?php

namespace Dothiv\ValueObject;

use Dothiv\ValueObject\Exception\InvalidArgumentException;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class URLValue extends AbstractValueObject implements ValueObjectInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string[]
     */
    private $parts;

    /**
     * @param string $url
     *
     * @throws InvalidArgumentException If an invalid url is provided.
     */
    public function __construct($url)
    {
        if ($url instanceof URLValue) {
            $this->url = (string)$url;
            return;
        }
        $this->parts = parse_url($url);
        if ($this->parts === false
            || !isset($this->parts['scheme'])
            || !isset($this->parts['host'])
        ) {
            throw new InvalidArgumentException(sprintf('Invalid url provided: "%s"', $url));
        }
        if (!isset($this->parts['path'])) {
            $url .= '/';
        }
        $this->url = $url;
    }

    /**
     * Static constructor.
     *
     * @param string $url
     *
     * @return URLValue
     */
    public static function create($url)
    {
        $c = __CLASS__;
        return new $c($url);
    }

    /**
     * {@inheritdoc}
     * @Serializer\HandlerCallback("json", direction = "serialization")
     */
    public function __toString()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function toScalar()
    {
        return $this->__toString();
    }

    /**
     * Returns the urls scheme.
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->getPart('scheme');
    }

    /**
     * Returns the urls hostname.
     *
     * @return string
     */
    public function getHostname()
    {
        return $this->getPart('host');
    }

    /**
     * Returns the urls path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getPart('path');
    }

    /**
     * Returns the urls query.
     *
     * @return string|null
     */
    public function getQuery()
    {
        return $this->getPart('query');
    }

    /**
     * Returns the urls fragment.
     *
     * @return string|null
     */
    public function getFragment()
    {
        return $this->getPart('fragment');
    }

    /**
     * @param string $part The part of the url to return.
     *
     * @return null|string
     */
    public function getPart($part)
    {
        return isset($this->parts[$part]) ? $this->parts[$part] : null;
    }
}
