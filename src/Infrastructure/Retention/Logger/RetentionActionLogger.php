<?php
declare(strict_types=1);


namespace Infrastructure\Retention\Logger;

use Domain\Retention\Logger\RetentionActionLoggerInterface;
use Infrastructure\Retention\Exception\UnsupportedByLoggerException;
use Model\Retention\UserAction;

final class RetentionActionLogger implements RetentionActionLoggerInterface
{
    /**
     * @var array<string,string>
     */
    private $filePaths;

    public function __construct(
        string $fileSmsAction,
        string $fileNoneAction
    ) {
        $this->filePaths = [
            UserAction::ACTION_SMS => $fileSmsAction,
            UserAction::ACTION_NONE => $fileNoneAction,
        ];
    }

    public function logAction(UserAction $action): void
    {
        if (false === array_key_exists($action->getAction(), $this->filePaths)) {
            throw new UnsupportedByLoggerException($action->getAction());
        }
        $fileName = $this->filePaths[$action->getAction()];
        $count = \file_get_contents($fileName);
        $count = false === $count
            ? 0
            : (int)$count;
        $count++;
        \file_put_contents($fileName, (string)$count);
    }
}
