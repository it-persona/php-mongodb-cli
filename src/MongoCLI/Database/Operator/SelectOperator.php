<?php

namespace MongoCLI\Database\Operator;

use MongoCLI\Exception\InvalidSyntaxException;

/**
 * Class SelectOperator
 * @package MongoCLI\Database\Operator
 */
class SelectOperator extends AbstractOperator
{
    /**
     * @param array $parts
     * @param $query
     */
    public function __construct(array $parts, $query)
    {
        parent::__construct($parts, $query);

        $this->key = 'select';
    }

    /**
     * @return bool
     * @throws InvalidSyntaxException
     */
    public function process()
    {
        $fields = trim(implode(' ', array_slice($this->parts,1)));

        if ($fields == '*') {
            $this->parameters = [];

            return true;
        }

        if (!str_contains($fields, ',') && !str_contains($fields, '.')) {
            $this->parameters[] = $fields;

            return true;
        }

        if (!str_contains($fields, ',') && str_contains($fields, '.')) {
            $this->parameters[] = $this->parseSubField($fields);

            return true;
        }

        $parameters = [];

        $fields = explode(',', $fields);

        $fields = array_map(function ($item) { return trim($item); }, $fields);

        foreach ($fields as $field) {
            var_dump($field);

            if (!str_contains($field, '.')) {
                $parameters[] = $field;

                continue;
            }

            $parameters[] = $this->parseSubField($field);
        }

        $this->parameters = $parameters;
    }

    /**
     * @param $field
     * @return mixed
     * @throws InvalidSyntaxException
     */
    private function parseSubField($field)
    {
        $subField = explode('.', $field);

        if (empty($subField[1]) || empty($subField[0])) {
            throw new InvalidSyntaxException($this->query);
        }

        if ($subField[1] == '*') {
            $field = $subField[0];
        }

        return $field;
    }
}
