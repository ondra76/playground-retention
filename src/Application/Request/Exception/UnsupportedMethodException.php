<?php
declare(strict_types=1);


namespace Application\Request\Exception;

use InvalidArgumentException;

final class UnsupportedMethodException extends InvalidArgumentException
{
    public function __construct(string $methodName)
    {
        parent::__construct("Method {$methodName} is not supported.");
    }
}
