<?php


namespace Oxygen\Providers\Templating\Plates;

use Oxygen\Contracts\AppContract;
use Oxygen\Contracts\Providers\Templating\RendererContract;
use Oxygen\Contracts\ServiceProviderContract;
use League\Plates\Engine;

class PlatesProvider implements  ServiceProviderContract
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var string|null
     */
    private $fileExtension;
    /**
     * @var array
     */
    private $folders;
    /**
     * @var Engine
     */
    private $engine;
    public function __construct(string $path, array $folders = [] ,?string $fileExtension=null)
    {
        $this->path = $path;
        $this->fileExtension = $fileExtension;
        $this->folders = $folders;
        $this->buildEngine();
    }

    private function buildEngine(){
       $this->engine = (new DecoratedEngine($this->path,$this->fileExtension));
       $this->loadExtensions();
       $this->loadFolders();
    }

    private function loadExtensions(){
        $this->engine->loadExtensions([
            new RoutingExtension()
        ]);
    }
    private function loadFolders(){
        foreach ($this->folders as $name => $data){
            if (!is_array($data)){
                $this->engine->addFolder($name,$this->viewPath($data));
            }else{
                $this->engine->addFolder($name,$this->viewPath($data["path"]),$data["fallback"]);
            }
        }
    }
    private function viewPath(string $path=""){
        return $this->path."/".$path;
    }
    public function register(AppContract $app)
    {
        $app->getContainer()->set(RendererContract::class,$this->engine);
        $app->getContainer()->set(Engine::class,$this->engine);
    }
}