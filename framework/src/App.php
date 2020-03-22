<?php
namespace Oxygen;
use Doctrine\Common\EventManager;
use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\ContainerContract;
use Oxygen\Contracts\EmitterContract;
use Oxygen\Contracts\Events\EventDispatcherContract;
use Oxygen\Contracts\ServiceProviderContract;
use Oxygen\Event\ApplicationEvents\MiddlewareLoaded;
use Oxygen\Event\EventDispatcher;
use Oxygen\Exceptions\RequestHandlerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class App implements AppContract
{

    private $container;
    public static $instance;
    private $response;
    
    private $middlewares = [];
    private $index = 0;
    /**
     * @var string
     */
    private $appPath;
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    public function __construct(
        ContainerContract $container,
        string $appPath
    ) {
        $this->eventDispatcher = new EventDispatcher();
        $this->container = $container;
        $this->appPath = $this->removeSlashesToPath($appPath);
        $this->boot();
    }

    /**
     * @param $middleware
     * @return $this
     * @throws RequestHandlerException
     */
    public function pipe($middleware):AppContract
    {
        $this->validateMiddleware($middleware);
        $this->middlewares[] = $middleware;
        return $this;
    }

    /**
     * @param $middleware
     * @return $this
     * @throws RequestHandlerException
     */
    public function pipeNext($middleware):AppContract
    {
        $this->validateMiddleware($middleware);
        $this->pipeAtPosition($this->index +1, $middleware);
        return $this;
    }

    /**
     * @param $middleware
     * @return AppContract
     * @throws RequestHandlerException
     */
    public function pipeReplacement($middleware):AppContract
    {
        $this->validateMiddleware($middleware);
        $this->pipeAtPosition($this->index, $middleware);
        return $this;
    }

    /**
     * @param $middleware
     * @return AppContract
     * @throws RequestHandlerException
     */
    public function load($middleware):AppContract{
        $this->pipeReplacement($middleware);
        return $this;
    }


    /**
     * @param int $index
     * @param $middleware
     * @return $this
     * @throws RequestHandlerException
     */
    public function pipeAtPosition(int $index, $middleware):AppContract
    {
        if (!$this->isValidIndex($index)) {
            throw new RequestHandlerException("The position [$index] is not valid. 
            It either the start, the end or in between the two! ");
        }
        $this->validateMiddleware($middleware);
        array_splice($this->middlewares, $index, 0, [$middleware]);
        return $this;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws RequestHandlerException
     */
    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        if (empty($this->middlewares)) {
            throw new RequestHandlerException("You need to pipe at least one middleware in the app!");
        }
        $currentMiddleware = $this->getCurrentMiddleware();
        $this->index++;
        if (!is_null($currentMiddleware)) {
            $this->eventDispatcher->dispatch(new MiddlewareLoaded($currentMiddleware));
            $this->response = $currentMiddleware->process($request, $this);
        }
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function emit(ResponseInterface $response)
    {
        if ($this->container->has(EmitterContract::class)) {
            $emitter = $this->container->get(EmitterContract::class);
        } else {
            $emitter = new Emitter();
        }
        return $emitter->emit($response);
    }

    /**
     * @return array
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * @return ContainerContract
     */
    public function getContainer():ContainerContract
    {
        return $this->container;
    }

    /**
     * @param ServiceProviderContract $provider
     * @return App
     */
    public function use(ServiceProviderContract $provider):AppContract{
        $provider->register($this);
        return $this;
    }

    /**
     * @param $index
     * @return bool
     */
    private function isValidIndex($index)
    {
        return ($index >= 0 && $index <= count($this->middlewares));
    }

    /**
     * @return MiddlewareInterface |null
     * @throws RequestHandlerException
     */
    private function getCurrentMiddleware():?MiddlewareInterface
    {
        if (!isset($this->middlewares[$this->index])) {
            return null;
        }
        return $this->buildMiddleware(
            $this->middlewares[$this->index]
        );
    }

    /**
     * @param $arg
     * @return bool
     */
    private function isValidMiddlewareArg($arg)
    {
        return is_string($arg) || $arg instanceof MiddlewareInterface;
    }

    /**
     * @param $middleware
     * @return String
     */
    private function getMiddlewareClassName($middleware):String
    {
        if (!is_object($middleware)) {
            return is_string($middleware)?($middleware): gettype($middleware);
        }
        return get_class($middleware);
    }

    /**
     * @param $middleware
     * @throws RequestHandlerException
     */
    private function validateMiddleware($middleware)
    {
        if (!$this->isValidMiddlewareArg($middleware)) {
            throw new RequestHandlerException("The middleware 
                [{$this->getMiddlewareClassName($middleware)}] is not valid");
        }
    }

    /**
     * @param $middleware
     * @return MiddlewareInterface | null
     * @throws RequestHandlerException
     */
    private function buildMiddleware($middleware):MiddlewareInterface
    {
        if (is_null($middleware)) {
            return null;
        }
        $instance = $middleware;
        if (is_string($middleware)) {
            $instance = $this->container->get($middleware);
        }
        if (!($instance instanceof MiddlewareInterface )) {
            throw new RequestHandlerException("The class [{$middleware}] must implements 
                the PSR-15 middleware interface!");
        }
        return $instance;
    }

    private function removeSlashesToPath(string $path){
        return trim(trim($path,"/"),"\\");
    }

    /**
     * @param string $classname
     * @return mixed
     */
    public function get(string $classname){
        return $this->container->get($classname);
    }

    public function set(string $abstract, $concrete){
        $this->container->set($abstract,$concrete);
    }

    public function has(string $abstract){
       return $this->container->has($abstract);
    }

    public function appPath(string $path = null):string{
        return $this->appPath.DIRECTORY_SEPARATOR.$this->removeSlashesToPath($path);
    }

    private function boot()
    {
        $this->container->set(ContainerContract::class,$this->container);
        $this->container->set(AppContract::class,$this);
        $this->container->set(EventDispatcherContract::class,$this->eventDispatcher);
        $this->container->set(EventDispatcher::class,$this->eventDispatcher);
        self::$instance = $this;
    }

    public function getEventDispatcher(): EventDispatcherContract
    {
        return $this->eventDispatcher;
    }
}
