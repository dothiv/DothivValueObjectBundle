<?php

namespace Dothiv\ValueObject;

use Dothiv\ValueObject\Exception\InvalidArgumentException;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class EmailValue extends AbstractValueObject implements ValueObjectInterface
{

    /**
     * @var string
     */
    private $email;

    /**
     * @var string[]
     */
    private $parts;

    /**
     * @param string $email
     *
     * @throws InvalidArgumentException If an invalid url is provided.
     */
    public function __construct($email)
    {
        if ($email instanceof EmailValue) {
            $this->email = (string)$email;
            return;
        }

        $valid = filter_var(idn_to_ascii($email), FILTER_VALIDATE_EMAIL);
        if (!$valid) {
            throw new InvalidArgumentException(sprintf('Invalid email value provided: "%s"!', $email));
        }
        $this->email = $email;
        list($user, $host) = explode('@', $email);
        if (strpos($user, '+')) {
            list($user, $extension) = explode('+', $user);
        } else {
            $extension = null;
        }
        $this->parts = array(
            'user'      => $user,
            'extension' => $extension,
            'host'      => $host,
        );
    }

    /**
     * Static constructor.
     *
     * @param string $email
     *
     * @return EmailValue
     */
    public static function create($email)
    {
        $c = __CLASS__;
        return new $c($email);
    }

    /**
     * {@inheritdoc}
     * @Serializer\HandlerCallback("json", direction = "serialization")
     */
    public function __toString()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function toScalar()
    {
        return $this->__toString();
    }

    /**
     * Returns the emails hostname.
     *
     * @return string
     */
    public function getHostname()
    {
        return $this->getPart('host');
    }

    /**
     * Returns the emails user.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->getPart('user');
    }

    /**
     * Returns the emails extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->getPart('extension');
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
