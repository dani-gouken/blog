<?php


namespace Infrastructure\DebugBar;

use Infrastructure\DebugBar\OxygenDebugBar;
use DebugBar\JavascriptRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\ResponseFactory;
use Zend\Diactoros\StreamFactory;

class DebugBarAssetMiddleware implements  MiddlewareInterface
{
    /**
     * @var OxygenDebugBar
     */
    private $debugBar;

    public function __construct(OxygenDebugBar $debugBar)
    {
        $this->debugBar = $debugBar;
    }

    const JS_URL = "/_debug/script";
    const CSS_URL= "/_debug/style";

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $jsRenderer = $this->debugBar->getJavascriptRenderer();
        if($path == self::JS_URL){
            ob_start();
            $jsRenderer->dumpJsAssets();
            $responseString = ob_get_clean();
            $responseBody = (new StreamFactory())->createStream($responseString);
            $response = (new ResponseFactory())->createResponse(200)->withBody($responseBody);
            $response = $response->withHeader("Content-Type","application/javascript");
            return $response;
        }

        if($path == self::CSS_URL){
            ob_start();
            $jsRenderer->dumpCssAssets();
            $responseString = ob_get_clean();
            $responseBody = (new StreamFactory())->createStream($responseString);
            $response = (new ResponseFactory())->createResponse(200)->withBody($responseBody);
            $response = $response->withHeader("Content-Type","text/css; charset=UTF-8");
            return $response;
        }
        return $handler->handle($request);

    }
}