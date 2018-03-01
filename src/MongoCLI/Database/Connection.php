<?php

namespace MongoCLI\Database;

use MongoDB\Client;

/**
 * Class Connection
 * @package MongoCLI\Database
 */
class Connection
{
    /**
     * @var string
     */
    private $uri;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $db;

    /**
     * Connect constructor.
     */
    public function __construct()
    {
        $this->uri = getenv('DB_HOST').':'.getenv('DB_PORT');
        $this->db = getenv('DB_NAME');
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->connection = new Client($this->uri);
        } catch (\Exception $exception) {
            echo "Error connection to database";
            exit(1);
        }
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return mixed
     */
    public function getDatabaseName()
    {
        $db = $this->getConnection()->selectDatabase($this->db);

        return $db->getDatabaseName();
    }

    /**
     * @return mixed
     */
    public function getCollections()
    {
        $db = $this->getConnection()->selectDatabase($this->db);

        return $db->listCollections();
    }

    /**
     * @param $collectionName
     * @param null $dbName
     * @return null
     */
    public function getCollection($collectionName, $dbName = null)
    {
        $collection = null;

        if ($collectionName) {
            $collection = $this->getConnection()
                ->selectCollection($dbName ? $dbName : $this->db, $collectionName);
        }

        return $collection;
    }
}