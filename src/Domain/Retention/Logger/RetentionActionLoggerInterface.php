<?php
declare(strict_types=1);


namespace Domain\Retention\Logger;

use Model\Retention\UserAction;

interface RetentionActionLoggerInterface
{
    public function logAction(UserAction $action): void;
}
