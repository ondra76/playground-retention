<?php
declare(strict_types=1);


namespace Infrastructure\Retention\Exception;

final class UnsupportedByLoggerException extends \InvalidArgumentException
{
    public function __construct(string $action)
    {
        parent::__construct("Action {$action} is not supported by the logger.");
    }
}
