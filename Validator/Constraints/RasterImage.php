<?php

namespace Ruvents\RuworkBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Image;

/**
 * @Annotation()
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class RasterImage extends Image
{
    public $mimeTypes = [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
    ];

    public $mimeTypesMessage = 'raster_image_invalid_mime_type';
}
