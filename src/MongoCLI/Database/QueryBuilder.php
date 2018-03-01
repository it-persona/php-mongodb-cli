<?php

namespace MongoCLI\Database;

/**
 * Class QueryBuilder
 * @package MongoCLI\Database
 */
class QueryBuilder
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $db;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->db = getenv('DB_NAME');
    }

    /**
     * @param $query
     * @return array
     */
    private function buildQuery($query): array
    {
        $db = $this->db;
        $collection = $query['from'];

        unset($query['from']);

        foreach ($query as $key => $parts) {
            $class = '\MongoCLI\Database\Query\\' . ucfirst($key) . 'Operator';

            $operator = new $class($parts);
            $operator->process();

            list($key, $parameters) = $operator->getParameters();

            $q[$key] = $parameters;
        }

        $q = $this->prepareQuery($q);

        return [
            $db,
            $collection,
            $q,
        ];
    }

    /**
     * @param array $query
     * @return array
     */
    private function prepareQuery($query = []): array
    {
        $filters = [];
        $options = [];

        if (array_key_exists('select', $query) && (sizeof($query['select']) > 0)) {
            $options['projection'] = $query['select'];
        }

        if (array_key_exists('limit', $query)) {
            $options['limit'] = $query['limit'];
        }

        if (array_key_exists('order', $query)) {
            $options['sort'] = $query['order'];
        }

        if (array_key_exists('skip', $query)) {
            $options['skip'] = $query['skip'];
        }

        if (array_key_exists('where', $query)) {
            $filters = $query['where'];
        }

        return [
            $filters,
            $options
        ];
    }

    /**
     * @param $db
     * @param $collection
     * @param $query
     * @return mixed
     */
    private function find($db, $collection, $query)
    {
        list($filters, $options) = $query;

        return $this
            ->connection
            ->getConnection()
            ->selectCollection($db, $collection)
            ->find($filters, $options)
            ;
    }

    public function run(Grammar $grammar)
    {
        list($db, $collection, $query) = $this->buildQuery($grammar->getQuery());

        $collection = new Collection($this->find($db, $collection, $query));

        return $collection->getCollection();
    }
}
