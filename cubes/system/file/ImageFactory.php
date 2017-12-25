<?php

namespace cubes\system\file;

class ImageFactory
{

    /**
     * @param File $file
     * @param string $baseDir
     *
     * @return Image
     */
    public function create(File $file, string $baseDir): Image
    {
        return new Image($file, $baseDir);
    }
}
