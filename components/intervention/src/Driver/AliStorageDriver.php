<?php

namespace Pis0sion\Intervention\Driver;

use League\Flysystem\Filesystem;

/**
 * \Pis0sion\Intervention\Driver\AliStorageDriver
 */
class AliStorageDriver
{
    /**
     * @var \League\Flysystem\Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * @param \League\Flysystem\Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getToken()
    {
        return $this->filesystem;
    }

}