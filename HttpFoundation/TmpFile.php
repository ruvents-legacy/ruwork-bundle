<?php

namespace Ruwork\CoreBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\File\File;

class TmpFile extends File
{
    /**
     * @param string|resource $contents
     */
    public function __construct($contents)
    {
        if (is_resource($contents)) {
            $contents = stream_get_contents($contents, -1, 0);
        }

        $pathname = rtrim(sys_get_temp_dir(), '/\\').DIRECTORY_SEPARATOR.uniqid();
        file_put_contents($pathname, $contents);

        parent::__construct($pathname);
    }
}
