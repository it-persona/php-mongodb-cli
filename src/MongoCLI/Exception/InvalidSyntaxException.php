<?php

namespace MongoCLI\Exception;

/**
 * Class InvalidSyntaxException
 * @package MongoCLI\Exception
 */
class InvalidSyntaxException extends \Exception
{
    /**
     * @param string $query
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($query = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct(sprintf('query "%s" has invalid syntax', $query));
    }
}
