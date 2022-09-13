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

namespace App\Repositories;

use App\Servlet\Contract\ServletInterface;

/**
 * \App\Repositories\AbstractRepositories.
 */
abstract class AbstractRepositories
{
    /**
     * @var \App\Servlet\Contract\ServletInterface
     */
    protected ServletInterface $servletFactory;

    /**
     * @param \App\Servlet\Contract\ServletInterface $servletFactory
     */
    public function __construct(ServletInterface $servletFactory)
    {
        $this->servletFactory = $servletFactory;
    }
}
