# SiteMap PSR-15 middleware 

[`SiteMapMiddleware`](src/SiteMapMiddleware.php) is a [PSR-15](https://www.php-fig.org/psr/psr-15/) middleware dedicated to answer `/sitemap.xml` requests. It uses [tackk/cartographer](https://github.com/tackk/cartographer) to generate the response in the [`sitemap.xml` format](https://www.sitemaps.org/protocol.html).


## Installation

This library is available through [Packagist](https://packagist.org/packages/codeinc/sitemap-middlware) and can be installed using [Composer](https://getcomposer.org/): 

```bash
composer require codeinc/sitemap-middlware
```

:speech_balloon: This library is extracted from the now deprecated [codeinc/psr15-middlewares](https://packagist.org/packages/codeinc/psr15-middlewares) package.


## License

The library is published under the MIT license (see [`LICENSE`](LICENSE) file).