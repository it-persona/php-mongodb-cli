<?php

namespace MongoCLI\Database\Operator;

use MongoCLI\Exception\InvalidSyntaxException;

class OrderOperator extends AbstractOperator
{
    /**
     * @var array
     */
    private $directions = [
        'asc',
        'desc',
    ];

    /**
     * @param array $parts
     * @param $query
     */
    public function __construct(array $parts, $query)
    {
        parent::__construct($parts, $query);

        $this->key = 'order';
    }

    /**
     * @throws InvalidSyntaxException
     */
    public function process()
    {
        $order = array_slice($this->parts, 2);
        $parameters = [];

        switch (sizeof($order)) {
            case 1:
                $parameters[$order[0]] = 'asc';
                break;

            case 2:
                if (!in_array(strtolower($order[1]), $this->directions)) {
                    throw new InvalidSyntaxException($this->query);
                }

                $parameters[$order[0]] = strtolower($order[1]);
                break;

            default:
                throw new InvalidSyntaxException($this->query);
        }

        $this->parameters = $parameters;
    }
}
