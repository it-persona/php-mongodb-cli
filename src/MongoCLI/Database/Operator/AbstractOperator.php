<?php

namespace MongoCLI\Database\Operator;

/**
 * Class AbstractOperator
 * @package MongoCLI\Database\Operator
 */
abstract class AbstractOperator
{
    /**
     * @var string
     */
    protected $query;

    /**
     * @var array
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
     * @param array $parts
     * @param $query
     */
    public function __construct(array $parts, $query)
    {
        $this->query = $query;
        $this->parts = $parts;
    }

    public function getParameters(): array
    {
        return [
            $this->key,
            $this->parameters
        ];
    }

    abstract public function process();
}
