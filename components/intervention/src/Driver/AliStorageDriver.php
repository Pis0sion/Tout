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
namespace Pis0sion\Intervention\Driver;

use League\Flysystem\Filesystem;

/**
 * \Pis0sion\Intervention\Driver\AliStorageDriver.
 */
class AliStorageDriver
{
    protected Filesystem $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getToken()
    {
        return $this->filesystem;
    }
}
