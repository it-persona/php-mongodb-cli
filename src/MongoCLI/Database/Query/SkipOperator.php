<?php

namespace MongoCLI\Database\Query;

/**
 * Class SkipOperator
 * @package MongoCLI\Database\Query
 */
class SkipOperator extends AbstractOperator
{
    /**
     * @param string $parts
     */
    public function __construct($parts)
    {
        parent::__construct($parts);

        $this->key = 'skip';
    }

    public function process()
    {
        $this->parameters = $this->parts;
    }
}
