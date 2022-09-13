<?php

namespace App\Exception;

/**
 * \App\Exception\InvalidSessionKeyException
 */
class InvalidSessionKeyException extends BaseException
{
    /**
     * @param int $httpCode
     * @param string $errMessage
     * @param int $errCode
     */
    public function __construct(
        public int    $httpCode = 400,
        public string $errMessage = 'sessionKey is invalid ...',
        public int    $errCode = 1000006
    )
    {
    }
}