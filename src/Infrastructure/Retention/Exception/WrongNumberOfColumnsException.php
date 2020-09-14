<?php
declare(strict_types=1);


namespace Infrastructure\Retention\Exception;

use Throwable;

final class WrongNumberOfColumnsException extends \Exception
{
    public function __construct(int $columnCount, int $requiredCount)
    {
        parent::__construct("Parsed CSV has {$columnCount} columns instead of {$requiredCount}.");
    }
}
