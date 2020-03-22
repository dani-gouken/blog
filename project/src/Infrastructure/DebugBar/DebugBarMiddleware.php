<?php


namespace Infrastructure\DebugBar;


use Infrastructure\DebugBar\Collectors\RoutesCollector;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\StreamFactory;

class DebugBarMiddleware implements MiddlewareInterface
{

    /**
     * @var OxygenDebugBar
     */
    private $debugBar;

    public function __construct(OxygenDebugBar $debugBar)
    {

        $this->debugBar = $debugBar;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $this->debugBar->addCollector($handler->get(RoutesCollector::class));
        $body = (string)$response->getBody();
        $urlString = $this->buildAssetsUrl();
        $result = str_replace("</body>",$urlString."</body>",$body);
        $factory = new StreamFactory();
        $response = $response->withBody($factory->createStream($result));
        return $response;
    }

    private function buildAssetsUrl()
    {
        $cssAssetUrl = DebugBarAssetMiddleware::CSS_URL;
        $jsAssetUrl = DebugBarAssetMiddleware::JS_URL;
        $cssString =  "<link type='text/css' rel='stylesheet' href='$cssAssetUrl'>";
        $JsString =  "<script type='application/javascript' src='$jsAssetUrl'></script>";
        return $cssString.$JsString.$this->debugBar->getJavascriptRenderer()->render();
    }
}