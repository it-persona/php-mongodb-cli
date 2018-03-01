<?php

namespace MongoCLI\Database\Operator;

use MongoCLI\Exception\InvalidSyntaxException;

/**
 * Class FromOperator
 * @package MongoCLI\Database\Operator
 */
class FromOperator extends AbstractOperator
{
    /**
     * @param array $parts
     * @param $query
     */
    public function __construct(array $parts, $query)
    {
        parent::__construct($parts, $query);

        $this->key = 'from';
    }

    /**
     * @throws InvalidSyntaxException
     */
    public function process()
    {
        $table = array_slice($this->parts, 1);

        if (sizeof($table) != 1) {
            throw new InvalidSyntaxException($this->query);
        }

        $this->parameters = $table[0];
    }
}
