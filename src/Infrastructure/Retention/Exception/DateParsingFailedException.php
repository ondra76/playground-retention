<?php
declare(strict_types=1);


namespace Infrastructure\Retention\Exception;

final class DateParsingFailedException extends \Exception
{
    public function __construct(string $date)
    {
        parent::__construct("Failed to parse a date ({$date}) in CSV file.");
    }
}
