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
// Time:     18:13
// Project:  SiteMapMiddleware
//
declare(strict_types=1);
namespace CodeInc\SiteMapMiddleware\Tests\CustomResponses;
use CodeInc\MiddlewareTestKit\BlankResponse;
use CodeInc\MiddlewareTestKit\FakeRequestHandler;
use CodeInc\MiddlewareTestKit\FakeServerRequest;
use CodeInc\SiteMapMiddleware\Assets\SiteMapResponse;
use CodeInc\SiteMapMiddleware\SiteMapMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tackk\Cartographer\ChangeFrequency;


/**
 * Class SiteMapMiddlewareTest
 *
 * @uses SiteMapMiddleware
 * @package CodeInc\SiteMapMiddleware\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class SiteMapMiddlewareTest extends TestCase
{
    public function testRegularRequest():void
    {
        $siteMapMiddleware = new SiteMapMiddleware();

        $request = FakeServerRequest::getSecureServerRequestWithPath('/test');
        self::assertFalse($siteMapMiddleware->isSiteMapRequest($request));
        $response = $siteMapMiddleware->process(
            $request,
            new FakeRequestHandler()
        );

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertInstanceOf(BlankResponse::class, $response);
    }

    public function testSiteMapRequest():void
    {
        foreach ([SiteMapMiddleware::DEFAULT_URI_PATH, '/custom-site-map.xml'] as $siteMapUriPath) {
            $siteMapMiddleware = new SiteMapMiddleware($siteMapUriPath);
            $siteMapMiddleware->add('http://foo.com', '2005-01-02', ChangeFrequency::WEEKLY, 1.0);
            $siteMapMiddleware->add('http://foo.com/about', '2005-01-01');

            $request = FakeServerRequest::getSecureServerRequestWithPath($siteMapUriPath);
            self::assertTrue($siteMapMiddleware->isSiteMapRequest($request));
            $response = $siteMapMiddleware->process(
                $request,
                new FakeRequestHandler()
            );

            self::assertInstanceOf(ResponseInterface::class, $response);
            self::assertInstanceOf(SiteMapResponse::class, $response);

            $responseBody = $response->getBody()->__toString();
            self::assertRegExp('#<loc>http://foo\\.com</loc>#ui', $responseBody);
            self::assertRegExp('#<loc>http://foo.com/about</loc>#ui', $responseBody);
        }
    }
}