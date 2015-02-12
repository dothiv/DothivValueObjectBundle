<?php

namespace Dothiv\ValueObject;

use Dothiv\ValueObject\Exception\InvalidArgumentException;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class HivDomainValue extends AbstractValueObject implements ValueObjectInterface
{

    /**
     * @var string
     */
    private $domain;

    /**
     * @var string[]
     */
    private $parts;

    /**
     * @see https://github.com/dothiv/idn-table
     */
    const ALLOWED_CHARS_NO_DASH = "0-9a-z\x{00E1}\x{00E4}\x{00E5}\x{00E6}\x{00E9}\x{00ED}\x{00F0}\x{00F1}\x{00F3}\x{00F6}\x{00F8}\x{00FA}\x{00FC}\x{00FD}\x{00FE}\x{0101}\x{0105}\x{0107}\x{010D}\x{0113}\x{0117}\x{0119}\x{0123}\x{012B}\x{012F}\x{0137}\x{013C}\x{0142}\x{0144}\x{0146}\x{014D}\x{0151}\x{0157}\x{015B}\x{0161}\x{016B}\x{0171}\x{0173}\x{017A}\x{017C}\x{017E}";

    /**
     * @param string $domain
     *
     * @throws InvalidArgumentException If an invalid url is provided.
     */
    public function __construct($domain)
    {
        if ($domain instanceof HivDomainValue) {
            $this->domain = (string)$domain;
            return;
        }

        $domain = trim(strtolower($domain));
        $regexp = "/^([a-z0-9]|xn--)(?:[a-z0-9]|-(?!-)){0,62}[a-z0-9]\.hiv$/";
        if (!preg_match($regexp, $domain)) {
            throw new InvalidArgumentException(sprintf('Invalid hiv domain provided: "%s"!', $domain));
        }

        // IDN character check
        $pattern    = '/^[' . static::ALLOWED_CHARS_NO_DASH . '][-' . static::ALLOWED_CHARS_NO_DASH . ']{0,61}[' . static::ALLOWED_CHARS_NO_DASH . ']\.hiv$/u';
        $domainUTF8 = idn_to_utf8($domain);
        if (!preg_match($pattern, $domainUTF8)) {
            throw new InvalidArgumentException(sprintf('hiv domain name contains invalid characters: "%s"!', $domain));
        }

        $this->domain = $domain;
        list($secondLevel,) = explode('.', $domain);
        $this->parts = array(
            'secondLevel' => $secondLevel
        );
    }

    /**
     * Static constructor.
     *
     * @param string $domain
     *
     * @return HivDomainValue
     */
    public static function create($domain)
    {
        $c = __CLASS__;
        return new $c($domain);
    }

    /**
     * Converts the value to a string.
     *
     * @return string
     * @Serializer\HandlerCallback("json", direction = "serialization")
     */
    public function __toString()
    {
        return $this->domain;
    }

    /**
     * {@inheritdoc}
     */
    public function toScalar()
    {
        return $this->__toString();
    }

    /**
     * @return null|string
     */
    public function getSecondLevel()
    {
        return $this->getPart('secondLevel');
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

    /**
     * Returns the UTF8 representation of the domain.
     *
     * @return string
     */
    public function toUTF8()
    {
        return idn_to_utf8($this->domain);
    }

    /**
     * Parses a UTF8 domain name.
     *
     * @return HivDomainValue
     */
    public static function createFromUTF8($utf8)
    {
        return new HivDomainValue(idn_to_ascii($utf8));
    }
}
