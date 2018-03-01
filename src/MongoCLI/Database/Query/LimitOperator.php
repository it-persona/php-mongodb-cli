<?php

namespace MongoCLI\Database\Query;

use MongoCLI\Exception\InvalidSyntaxException;

/**
 * Class LimitOperator
 * @package MongoCLI\Database\Query
 */
class LimitOperator extends AbstractOperator
{
    /**
     * @param string $parts
     */
    public function __construct($parts)
    {
        parent::__construct($parts);

        $this->key = 'limit';
    }

    public function process()
    {
        $this->parameters = $this->parts;
    }
}
