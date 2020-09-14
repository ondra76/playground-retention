<?php
declare(strict_types=1);


namespace Application\Container\Exception;

final class EnvironmentVariableNotFoundException extends \Exception
{
    public function __construct(string $environmentVariableName)
    {
        parent::__construct("Requested environment variable ({$environmentVariableName}) is missing.");
    }
}
