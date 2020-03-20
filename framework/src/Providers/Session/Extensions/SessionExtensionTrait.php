<?php


namespace Oxygen\Providers\Session\Extensions;


use Oxygen\Contracts\Providers\SessionManagerContract;
use Oxygen\Providers\Session\FlashMessageManager;

trait SessionExtensionTrait
{
    /**
     * @var SessionManagerContract
     */
    public $sessionManager;
    /**
     * @var FlashMessageManager
     */
    public $flashMessageManager;
    public function __construct(
        SessionManagerContract $sessionManager,
        FlashMessageManager $flashMessageManager
    )
    {
        $this->sessionManager = $sessionManager;
        $this->flashMessageManager = $flashMessageManager;
    }

    public function session(){
        return $this->sessionManager;
    }

    public function flasher(){
        return $this->flashMessageManager;
    }

    public function getAvailableMethods(){
        return array_filter(get_class_methods(SessionExtensionTrait::class),function($item){
            return $item != "getAvailableMethods";
        });
    }
}