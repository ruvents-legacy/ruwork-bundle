<?php

namespace Ruwork\CoreBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ImmediateFileResponse extends Response
{
    /**
     * @param string $content
     * @param string $filename
     * @param string $contentType
     */
    public function __construct($content, $filename, $contentType = 'text/plain')
    {
        parent::__construct($content);

        $disposition = $this->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
        $this->headers->set('Content-Disposition', $disposition);
        $this->headers->set('Content-Type', $contentType);
    }
}
