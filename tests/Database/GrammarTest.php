<?php

namespace Tests\Database;

use PHPUnit\Framework\TestCase;
use MongoCLI\Database\Grammar;

class GrammarTest extends TestCase
{
    /**
     * @var Grammar
     */
    public static $grammar;

    /**
     * @return void
     */
    public static function setUpBeforeClass()
    {
        self::$grammar = new Grammar();
    }

    /**
     * @dataProvider queries
     */
    public function testGrammarWorking($query, $result)
    {
        self::$grammar->setQuery($query);

        $this->assertEquals($result, self::$grammar->getQuery());
    }

    /**
     *
     */
    public function queries()
    {
       return [
           [
               'SELECT * FROM table',
               [
                   'select' => [],
                   'from' => 'table',
               ]
           ],
           [
               'SELECT field FROM table',
               [
                   'select' => [
                       'field'
                   ],
                   'from' => 'table',
               ]
           ],
           [
               'SELECT * FROM table ORDER BY field DESC',
               [
                   'select' => [],
                   'from'   => 'table',
                   'order'  => [
                       'field' => 'desc',
                   ]
               ]
           ],
           [
               'SELECT * FROM table LIMIT 5 SKIP 2',
               [
                   'select' => [],
                   'from'   => 'table',
                   'limit'  => 5,
                   'skip'   => 2,
               ]
           ],
           [
               'SELECT * FROM table WHERE a>=1 OR b<=5',
               [
                   'select' => [],
                   'from'   => 'table',
                   'where'  => [
                       '$or' => [
                           [
                               'a' => [
                                   '$gte' => 1,
                               ]
                           ],
                           [
                               'b' => [
                                   '$lte' => 5,
                               ]
                           ]
                       ]
                   ]
               ]
           ]
       ];
    }
}
