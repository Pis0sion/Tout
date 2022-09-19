<?php

namespace App\Controller\V1;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Pis0sion\Intervention\Contract\ContractGeneratorFactoryInterface;

/**
 * \App\Controller\V1\EntryController
 */
#[Controller(prefix: '/v1/entry')]
class EntryController
{
    #[RequestMapping(path: "wechat-launch", methods: "POST")]
    public function wechatLaunch(ContractGeneratorFactoryInterface $contractGeneratorFactory, RequestInterface $request)
    {
        $pageTemplateParameters = $request->input("tmplParameters");
        return $contractGeneratorFactory->generatorContract($pageTemplateParameters);
    }
}