<?php

namespace MongoCLI\Database\Query;

/**
 * Class SelectOperator
 * @package MongoCLI\Database\Query
 */
class SelectOperator extends AbstractOperator
{
    /**
     * @param array $parts
     */
    public function __construct(array $parts)
    {
        parent::__construct($parts);

        $this->key = 'select';
    }

    public function process()
    {
        $parameters = [];

        foreach ($this->parts as $part) {
            $parameters[$part] = 1;
        }

        $this->parameters = $parameters;
    }
}
