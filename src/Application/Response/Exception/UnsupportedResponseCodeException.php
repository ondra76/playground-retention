<?php
declare(strict_types=1);


namespace Application\Response\Exception;

use InvalidArgumentException;

final class UnsupportedResponseCodeException extends InvalidArgumentException
{
    public function __construct(int $code)
    {
        parent::__construct("Code ({$code}) is not supported by response.");
    }
}
