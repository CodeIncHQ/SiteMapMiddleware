<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2017 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material  is strictly forbidden unless prior   |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     02/05/2018
// Time:     17:58
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\SiteMapMiddleware;
use CodeInc\SiteMapMiddleware\Assets\SiteMapResponse;
use CodeInc\SiteMapMiddleware\Tests\CustomResponses\SiteMapMiddlewareTest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tackk\Cartographer\Sitemap;


/**
 * Class SiteMapMiddleware
 *
 * @see SiteMapMiddlewareTest
 * @uses Sitemap <https://github.com/tackk/cartographer>
 * @package CodeInc\SiteMapMiddleware
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/SiteMapMiddleware/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/SiteMapMiddleware
 */
class SiteMapMiddleware extends Sitemap implements MiddlewareInterface
{
    public const DEFAULT_URI_PATH = '/sitemap.xml';

    /**
     * @var string
     */
    private $uriPath;

    /**
     * SiteMapMiddleware constructor.
     *
     * @param string $uriPath
     */
    public function __construct(string $uriPath = self::DEFAULT_URI_PATH)
    {
        parent::__construct();
        $this->uriPath = $uriPath;
    }

    /**
     * Returne the URI path for which the robots.txt file is returned.
     *
     * @return string
     */
    public function getUriPath():string
    {
        return $this->uriPath;
    }

    /**
     * @inheritdoc
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
    {
        if ($this->isSiteMapRequest($request)) {
            return new SiteMapResponse($this);
        }
        else {
            return $handler->handle($request);
        }
    }

    /**
     * Verifies if the requests points toward the robots.txt file.
     *
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isSiteMapRequest(ServerRequestInterface $request):bool
    {
        return $request->getUri()->getPath() == $this->uriPath;
    }
}