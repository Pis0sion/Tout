<?php

namespace App\Controller\V1;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * \App\Controller\V1\EntryController
 */
#[Controller(prefix: '/v1/entry')]
class EntryController
{
    #[RequestMapping(path: "wechat-launch", methods: "POST")]
    public function wechatLaunch(RequestInterface $request)
    {
        return renderResponse(["method" => __FUNCTION__]);
    }
}