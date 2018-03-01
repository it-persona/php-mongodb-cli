<?php

namespace MongoCLI\Database\Query;

/**
 * Class AbstractOperator
 * @package MongoCLI\Database\Query
 */
abstract class AbstractOperator
{
    /**
     * @var array|string
     */
    protected $parts;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @param array|string $parts
     */
    public function __construct($parts)
    {
        $this->parts = $parts;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return [
            $this->key,
            $this->parameters
        ];
    }

    abstract public function process();
}
