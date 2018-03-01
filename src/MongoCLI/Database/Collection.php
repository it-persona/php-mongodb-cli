<?php

namespace MongoCLI\Database;

use MongoDB\Driver\Cursor;

/**
 * Class Collection
 * @package MongoCLI\Database
 */
class Collection
{
    private $cursor;

    /**
     * @param Cursor $cursor
     */
    public function __construct(Cursor $cursor)
    {
        $this->cursor = $cursor;
    }

    public function getCollection(): array
    {
        $result = [];

        foreach ($this->cursor as $item) {
            $result[] = $item;
        }

        return $result;
    }
}
