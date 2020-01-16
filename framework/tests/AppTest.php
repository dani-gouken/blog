<?php
namespace Oxygen\Test;

use Oxygen\App;
use Oxygen\Contracts\ContainerContract;
use Oxygen\Exceptions\RequestHandlerException;
use Prophecy\Argument;
use Prophecy\Prophet;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class AppTest extends BasicTest {

	public function testIfItCanBeConstructed(){
		$app = $this->createApp();
		$this->assertInstanceOf(App::class,$app);
		$this->assertInstanceOf(ContainerContract::class,$app->getContainer());
	}

	public function testItSaveTheInstanceOfTheApp(){
		App::$instance = null;
		$app = $this->createApp();
		$this->assertSame($app,App::$instance);
	}


	public function testItPipeAMiddleware(){
		$app = $this->createApp();
		$stubMiddleware1 = $this->createStub(MiddlewareInterface::class);
		$stubMiddleware2 = $this->createStub(MiddlewareInterface::class);

		$this->assertSame([],$app->getMiddlewares());
		
		$app->pipe($stubMiddleware1);
		$app->pipe($stubMiddleware2);

		$this->assertSame(2,count($app->getMiddlewares()));
		$this->assertContains($stubMiddleware2,$app->getMiddlewares());
		$this->assertContains($stubMiddleware1,$app->getMiddlewares());
	}

	public function testItThrowIfYoutryToPipeAndInvalidMiddleware(){
		$app = $this->createApp();
		$this->expectException(RequestHandlerException::class);
		$app->pipe([]);
	}

	public function testIfItPipeAMiddlewareAtASpecificPosition(){
		$app = $this->createApp();

		$stubMiddleware1 = $this->createStub(MiddlewareInterface::class);
		$stubMiddleware2 = $this->createStub(MiddlewareInterface::class);
		$stubMiddleware3 = $this->createStub(MiddlewareInterface::class);

		$app->pipeAtPosition(0,$stubMiddleware1);		
		$app->pipeAtPosition(1,$stubMiddleware2);

		$app->pipeAtPosition(1,$stubMiddleware3);
		$middlewares = $app->getMiddlewares();
		$this->assertSame($middlewares[1],$stubMiddleware3);		
		$this->assertSame($middlewares[0],$stubMiddleware1);		
		$this->assertSame($middlewares[2],$stubMiddleware2);		
	}

	public function testItThrowIfTheGivenIndexIsNotValid(){
		$app = $this->createApp();
		$this->expectException(RequestHandlerException::class);
		$app->pipeAtPosition(4,$this->createStub(MiddlewareInterface::class));
	}

	public function testIfItPipeAMiddlewareAsTheNextOne(){
		$app = $this->createApp();
		$stubMiddleware1 = $this->createStub(MiddlewareInterface::class);
		$stubMiddleware2 = $this->createStub(MiddlewareInterface::class);
		$stubMiddleware3 = $this->createStub(MiddlewareInterface::class);

		$app->pipe($stubMiddleware1);
		$app->pipe($stubMiddleware2);
		$app->pipeNext($stubMiddleware3);

		$middlewares = $app->getMiddlewares();
		$this->assertSame($middlewares[0],$stubMiddleware1);		
		$this->assertSame($middlewares[1],$stubMiddleware3);	
		$this->assertSame($middlewares[2],$stubMiddleware2);	
	}

	public function testThatItHandleARequest(){
		$app = $this->createApp();
        $prophet = new Prophet();
        $prophecyMiddleware = $prophet->prophesize(MiddlewareInterface::class);
        $prophecyMiddleware2 = $prophet->prophesize(MiddlewareInterface::class);
        $prophecyResponse = $prophet->prophesize(ResponseInterface::class);
        $prophecyResponse->withHeader(Argument::type('string'),Argument::type('string'))->will(function ($args) {
            $this->getHeader($args[0])->willReturn($args[1]);
        });;

        $prophecyMiddleware->process(Argument::any(),Argument::any())->will(function($args){
            $args[0]->withAttribute("framework","Oxygen");
            return $args[1]->handle($args[0]);
        })->shouldBeCalledTimes(1);

        $prophecyRequest = $prophet->prophesize(ServerRequestInterface::class);
        $prophecyRequest->withAttribute(Argument::type('string'),Argument::type('string'))->will(function ($args) {
            $this->getAttribute($args[0])->willReturn($args[1]);
        });
        $prophecyMiddleware2->process(Argument::any(),Argument::any())
        ->will(function($args)
        use($prophecyResponse){
           $prophecyResponse->withHeader(Argument::type('string'))->will(function ($args) {
                $this->getHeader()->willReturn($args[0]);
            });
           $response = $prophecyResponse->reveal();
            $response->withHeader("framework",$args[0]->getAttribute("framework"));
            return $response;
        })->shouldBeCalledTimes(1);

        $app->pipe($prophecyMiddleware->reveal())
            ->pipe($prophecyMiddleware2->reveal());
        $response = $app->handle($prophecyRequest->reveal());
        $this->assertEquals("Oxygen",$response->getHeader("framework"));
        $prophet->checkPredictions();
    }

    public function testItThrowIfTheNoMiddlewareWasPiped(){
        $this->expectException(RequestHandlerException::class);
        $app = $this->createApp();
        $app->handle($this->createStub(ServerRequestInterface::class));
    }

}