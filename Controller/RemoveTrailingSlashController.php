<?php

namespace Ruvents\RuworkBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RemoveTrailingSlashController
{
    /**
     * @Route("/{path}", requirements={"path": ".*\/$"}, methods={"GET"})
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $pathInfo = rtrim(urldecode($request->getPathInfo()), ' /');
        $query = $request->getQueryString();

        $uri = $request->getUriForPath($pathInfo).($query ? '?'.$query : '');

        return new RedirectResponse($uri, 301);
    }
}
