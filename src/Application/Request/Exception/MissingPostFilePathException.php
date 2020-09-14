<?php
declare(strict_types=1);


namespace Application\Request\Exception;

final class MissingPostFilePathException extends \InvalidArgumentException
{
    public function __construct(string $formFieldName)
    {
        parent::__construct("Path to post file on field ({$formFieldName}) is missing.");
    }
}
