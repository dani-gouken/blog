<?php
namespace Oxygen\Test;

use Oxygen\App;
use Oxygen\Contracts\ContainerContract;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class BasicTest extends TestCase
{
	public function createApp(){
		$stubContainer = $this->createStub(ContainerContract::class);
		$app = new App($stubContainer);
		return $app;
	} 

	public function setProtectedProperty($object, $property, $value){
        try {
            $reflection = new ReflectionClass($object);
            $reflection_property = $reflection->getProperty($property);
            $reflection_property->setAccessible(true);
            $reflection_property->setValue($object, $value);
        } catch (\ReflectionException $e) {
            throw $e;
        }
	}

}