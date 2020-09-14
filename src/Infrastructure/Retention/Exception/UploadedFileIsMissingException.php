<?php
declare(strict_types=1);


namespace Infrastructure\Retention\Exception;

use Throwable;

final class UploadedFileIsMissingException extends \InvalidArgumentException
{
    public function __construct(string $filePath)
    {
        parent::__construct("Uploaded file ({$filePath} is missing.)");
    }
}
