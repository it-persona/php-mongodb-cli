<?php

namespace MongoCLI\Database\Operator;

use MongoCLI\Exception\InvalidSyntaxException;

/**
 * Class SkipOperator
 * @package MongoCLI\Database\Operator
 */
class SkipOperator extends AbstractOperator
{
    /**
     * @param array $parts
     * @param $query
     */
    public function __construct(array $parts, $query)
    {
        parent::__construct($parts, $query);

        $this->key = 'skip';
    }

    /**
     * @throws InvalidSyntaxException
     */
    public function process()
    {
        $skip = array_slice($this->parts, 1);

        if (sizeof($skip) != 1) {
            throw new InvalidSyntaxException($this->query);
        }

        $this->parameters = (int) $skip[0];
    }
}
