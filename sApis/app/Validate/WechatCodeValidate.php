<?php

namespace App\Validate;

/**
 * \App\Validate\WechatCodeValidate
 */
class WechatCodeValidate extends BaseValidate
{
    /**
     * @var array
     */
    protected array $rules = [
        "code" => "required|string"
    ];

    /**
     * @var array|string[]
     */
    protected array $messages = [
        "required" => "The :attribute value must be passed.",
        "string" => "The :attribute value must be string type."
    ];

}