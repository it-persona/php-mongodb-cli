<?php

namespace MongoCLI\Database\Query;

/**
 * Class WhereOperator
 * @package MongoCLI\Database\Query
 */
class WhereOperator extends AbstractOperator
{
    /**
     * @var array
     */
    protected $compareOperators = [
        'ne'  => '$ne',
        'gte' => '$gte',
        'gt'  => '$gt',
        'eq'  => '$eq',
        'lte' => '$lte',
        'lt'  => '$lt',
    ];

    /**
     * @param array $parts
     */
    public function __construct($parts)
    {
        parent::__construct($parts);

        $this->key = 'where';
    }

    public function process()
    {
        $this->parameters = $this->parts;
    }
}
