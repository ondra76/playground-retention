<?php
declare(strict_types=1);


namespace Application\Request\Exception;

use InvalidArgumentException;

final class MissingServerKeyException extends InvalidArgumentException
{
    public function __construct(string $keyName)
    {
        parent::__construct("Key ($keyName) is missing in server vars.");
    }
}
