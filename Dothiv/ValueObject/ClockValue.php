<?php

namespace Dothiv\ValueObject;

/**
 * The clock service abstracts the current date.
 */
class ClockValue
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
} 
