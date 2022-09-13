<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Exception;

use App\Kernel\Enum\ResponseCodeEnum;
use Doctrine\Common\Annotations\Annotation\Enum;

/**
 * \App\Exception\BaseException.
 */
class BaseException extends \Exception
{
    /**
     * @param int $httpCode
     * @param string $errMessage
     * @param int $errCode
     */
    public function __construct(
        public int    $httpCode = 400,
        public string $errMessage = 'Request Failed, Please try again later...',
        public int    $errCode = 1000001,
    )
    {
    }
}
