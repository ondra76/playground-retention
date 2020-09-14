<?php
declare(strict_types=1);


namespace Application\Response\Exception;

use LogicException;

final class PrintingResponseTwiceException extends LogicException
{
    public function __construct()
    {
        parent::__construct('Trying to print a response second time');
    }
}
