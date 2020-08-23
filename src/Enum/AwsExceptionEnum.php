<?php /** @noinspection PhpUnused */

namespace App\Enum;

class AwsExceptionEnum extends BasicEnum
{
    const TABLE_NOT_EXIST   = 'ResourceNotFoundException';
    const CONDITIONAL_FAIL  = 'ConditionalCheckFailedException';
}
