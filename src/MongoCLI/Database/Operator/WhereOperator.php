<?php

namespace MongoCLI\Database\Operator;

use MongoCLI\Exception\InvalidSyntaxException;

/**
 * Class WhereOperator
 * @package MongoCLI\Database\Operator
 */
class WhereOperator extends AbstractOperator
{
    /**
     * @var array
     */
    protected $compareOperators = [
        '<>' => '$ne',
        '>=' => '$gte',
        '>'  => '$gt',
        '<=' => '$lte',
        '<'  => '$lt',
        '='  => '$eq',
    ];

    /**
     * @param array $parts
     * @param $query
     */
    public function __construct(array $parts, $query)
    {
        parent::__construct($parts, $query);

        $this->key = 'where';
    }

    /**
     * @throws InvalidSyntaxException
     */
    public function process()
    {
        $expressions = array_slice($this->parts, 1);

        if ((sizeof($expressions) % 2) == 0) {
            throw new InvalidSyntaxException($this->query);
        }

        if (sizeof($expressions) == 1) {
            $this->parameters = $this->parseExpression($expressions[0]);
        }

        $previousExpression = $this->parseExpression($expressions[0]);

        foreach ($expressions as $key => $part) {
            if (($key % 2) == 0) {
                continue;
            }

            switch (strtolower($part)) {
                case 'and':
                    $previousExpression = [
                        '$and' => [
                            $previousExpression,
                            $this->parseExpression($expressions[$key + 1]),
                        ]
                    ];
                    break;

                case 'or':
                    $previousExpression = [
                        '$or' => [
                            $previousExpression,
                            $this->parseExpression($expressions[$key + 1]),
                        ],
                    ];
                    break;

                default:
                    throw new InvalidSyntaxException($this->query);
            }
        }

        $this->parameters = $previousExpression;
    }

    /**
     * @param $expression
     * @return array
     * @throws InvalidSyntaxException
     */
    private function parseExpression($expression): array
    {
        $compares = [];

        foreach (array_keys($this->compareOperators) as $operator) {
            if (!str_contains($expression, $operator)) {
                continue;
            }

            $expressions = explode($operator, $expression);

            if (sizeof($expressions) != 2) {
                throw new InvalidSyntaxException($this->query);
            }

            $compares[trim(trim($expressions[0], '\''), '\"')] = is_numeric($expressions[1])
                    ? [ $this->compareOperators[$operator] => intval($expressions[1]), ]
                    : [ $this->compareOperators[$operator] => trim(trim($expressions[1], '\''), '\"'), ]
            ;
            break;
        }

        return $compares;
    }
}
