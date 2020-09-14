<?php
declare(strict_types=1);


namespace Application\Request\Exception;

use InvalidArgumentException;

final class EmptyRequestUriException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct("Provided uri is empty.");
    }
}
