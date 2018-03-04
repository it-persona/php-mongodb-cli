<?php

namespace Tests\Database;

use MongoDB\Client;
use PHPUnit\Framework\TestCase;
use MongoCLI\Database\Connection;

class ConnectionTest extends TestCase
{
    /**
     * @var Connection
     */
    public static $connection;

    public function setUp()
    {
        self::$connection = new Connection();
    }

    public function testGetConnection()
    {
          $this->assertInstanceOf(Client::class, self::$connection->getConnection());
    }

    public function testGetDatabaseName()
    {
        $this->assertNotNull(self::$connection->getDatabaseName());
    }

    public function testGetCollections()
    {
        $this->assertNotNull(self::$connection->getCollections());
    }

}
