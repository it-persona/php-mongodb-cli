<?php

namespace Tests\Database;

use PHPUnit\Framework\TestCase;
use MongoCLI\Database\Connection;
use MongoCLI\Database\Grammar;
use MongoCLI\Database\QueryBuilder;

class QueryBuilderTest extends TestCase
{
    /**
     * @var QueryBuilder
     */
    public static $queryBuilder;

    /**
     * @return void
     */
    public static function setUpBeforeClass()
    {
        $connection = new Connection();

        self::$queryBuilder = new QueryBuilder($connection);
    }

    /**
     * @dataProvider queries
     */
    public function testGrammarWorking(string $query)
    {
        $grammar = new Grammar();

        $this->assertTrue(is_array(self::$queryBuilder->run($grammar->setQuery($query))));
    }

    /**
     * @return array
     */
    public function queries(): array
    {
       return [
           ['SELECT * FROM table'],
           ['SELECT field FROM table'],
           ['SELECT * FROM table ORDER BY field DESC'],
           ['SELECT * FROM table LIMIT 5 SKIP 2'],
           ['SELECT * FROM table WHERE a>1 OR b<=5'],
           ['SELECT * FROM table WHERE a>=1 AND b=5']
       ];
    }
}
