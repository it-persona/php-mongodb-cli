<?php

namespace MongoCLI\Database;

use MongoCLI\Exception\InvalidSyntaxException;

/**
 * Class Grammar
 * @package MongoCLI\Database
 */
class Grammar
{
    /**
     * @var string
     */
    const PATTERN = '/(select [\w\d\*\_\.\ \,]+)( from [\w\d\.\*]+)(( where(\ ?(and|or){0,} [\w\_\d\.\*]{1,}(=|<>|>|>=|<|<=)[\w\_\d\.\*\'\"]{1,}){1,})|( order by [\w\d\_]+( asc| desc)?)|( skip [\d]+)|( limit [\d]+)){0,}/i';

    /**
     * @var array
     */
    public static $operators = [
        'select',
        'from',
        'where',
        'order',
        'limit',
        'skip',
    ];

    /**
     * @var string $query
     */
    private $query;

    /**
     * @var array $blocks Query blocks
     */
    private $blocks;

    /**
     * @param $query
     * @return array
     */
    private function handleQuery($query): array
    {
        return $this->filterQuery(
            $this->removeDoubleSpaces(
                $query
            )
        );
    }

    /**
     * @param $query
     * @return array
     */
    private function filterQuery($query): array
    {
        $matches = [];

        preg_match(self::PATTERN, $query,$matches);

        $matches = array_filter(array_unique($matches), function ($item) {
            return str_contains(strtolower($item), self::$operators);
        });

        $matches = array_map(function ($item) { return trim($item); }, $matches);

        return array_slice($matches, 1);
    }

    /**
     * @param array $blocks
     * @return array
     * @throws InvalidSyntaxException
     */
    private function parseQuery(array $blocks): array
    {
        if (sizeof($blocks) < 2) {
            throw new InvalidSyntaxException($this->query);
        }

        $parameters = [];

        foreach ($blocks as $block) {
            $parts = explode(' ', $block);

            if (sizeof($parts) < 2) {
                throw new InvalidSyntaxException($this->query);
            }

            if (array_key_exists($parts[0], $parameters)) {
                throw new InvalidSyntaxException($this->query);
            }

            if (!in_array(strtolower($parts[0]), Grammar::$operators)) {
                throw new InvalidSyntaxException($this->query);
            }

            $class = '\MongoCLI\Database\Operator\\' . ucfirst(strtolower($parts[0])) . 'Operator';

            $operator = new $class($parts, $this->query);
            $operator->process();

            list($key, $parameter) = $operator->getParameters();

            $parameters[$key] = $parameter;
        }

        return $parameters;
    }

    /**
     * @param $query
     * @return string
     */
    private function removeDoubleSpaces($query): string
    {
        return implode(' ', array_filter(explode(' ', $query)));
    }

    /**
     * @param $query
     * @return $this
     */
    public function setQuery($query)
    {
        /**
         * @var string
         */
        $this->query = $query;

        /**
         * @var array
         */
        $this->blocks = $this->handleQuery($query);

        return $this;
    }

    /**
     * @throws InvalidSyntaxException
     */
    public function getQuery(): array
    {
        return $this->parseQuery($this->blocks);
    }
}
