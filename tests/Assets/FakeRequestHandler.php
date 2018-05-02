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
// Date:     27/04/2018
// Time:     11:05
// Project:  SiteMapMiddleware
//
declare(strict_types=1);
namespace CodeInc\SiteMapMiddleware\Tests\Assets;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class FakeRequestHandler
 *
 * @package CodeInc\SiteMapMiddleware\Tests\Assets
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class FakeRequestHandler implements RequestHandlerInterface
{
    /**
     * @var BlankResponse|null|ResponseInterface
     */
    private $response;


    /**
     * FakeRequestHandler constructor.
     *
     * @param null|ResponseInterface $response
     */
    public function __construct(?ResponseInterface $response = null)
    {
        $this->response = $response ?? new BlankResponse();
    }


    /**
     * @inheritdoc
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        return $this->response;
    }
}