<?php

namespace MongoCLI\Database\Query;

/**
 * Class OrderOperator
 * @package MongoCLI\Database\Query
 */
class OrderOperator extends AbstractOperator
{
    /**
     * @param array $parts
     */
    public function __construct($parts)
    {
        parent::__construct($parts);

        $this->key = 'order';
    }

    public function process()
    {
        $parameters = [];

        foreach ($this->parts as $field => $direction) {
            $parameters[$field] = ($direction == 'asc') ? 1 : -1;
        }

        $this->parameters = $parameters;
    }
}
