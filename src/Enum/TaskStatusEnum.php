<?php /** @noinspection PhpUnused */

namespace App\Enum;

class TaskStatusEnum extends BasicEnum
{
    const TODO      = 'todo';
    const COMPLETED = 'completed';
    const CANCELED  = 'canceled';
    const ARCHIVED  = 'archived';
}
