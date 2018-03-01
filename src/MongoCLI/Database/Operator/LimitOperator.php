<?php

namespace MongoCLI\Database\Operator;

use MongoCLI\Exception\InvalidSyntaxException;

/**
 * Class LimitOperator
 * @package MongoCLI\Database\Operator
 */
class LimitOperator extends AbstractOperator
{
    /**
     * @param array $parts
     * @param $query
     */
    public function __construct(array $parts, $query)
    {
        parent::__construct($parts, $query);

        $this->key = 'limit';
    }

    /**
     * @throws InvalidSyntaxException
     */
    public function process()
    {
        $limit = array_slice($this->parts, 1);

        if (sizeof($limit) != 1) {
            throw new InvalidSyntaxException($this->query);
        }

        $this->parameters = (int) $limit[0];
    }
}
