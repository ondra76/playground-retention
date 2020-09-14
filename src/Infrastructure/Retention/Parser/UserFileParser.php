<?php
declare(strict_types=1);


namespace Infrastructure\Retention\Parser;

use Infrastructure\Retention\Exception\DateParsingFailedException;
use Infrastructure\Retention\Exception\UploadedFileIsMissingException;
use Infrastructure\Retention\Exception\WrongNumberOfColumnsException;
use Model\Retention\User;

final class UserFileParser
{
    private const DELIMITER = ',';
    private const MAX_LINE_LENGHT = 1000;

    /**
     * @return User[]
     */
    public function parseUserCsv(string $filePath): array
    {
        $parsedUsers = [];
        $handle = fopen($filePath, 'r');
        if (false === $handle) {
            throw new UploadedFileIsMissingException($filePath);
        }

        while (($data = \fgetcsv($handle, self::MAX_LINE_LENGHT, self::DELIMITER)) !== false) {
            if (count($data) !== 3) {
                throw new WrongNumberOfColumnsException(
                    count($data),
                    3
                );
            }
            $parsedDate = \DateTimeImmutable::createFromFormat(
                'd.m.Y',
                trim($data[2])
            );
            if (false === $parsedDate) {
                throw new DateParsingFailedException($data[2]);
            }

            $parsedUsers[] = new User(
                trim($data[0]),
                (int)$data[1],
                $parsedDate
            );
        }
        fclose($handle);

        return $parsedUsers;
    }
}
