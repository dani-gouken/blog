<?php

namespace Oxygen\Test\Routing;
use Oxygen\Providers\Routing\Route;
use Oxygen\Providers\Routing\RouteGroup;
use Oxygen\Providers\Routing\RouteParser;
use Oxygen\Test\BasicTest;

class RouteParserTest extends BasicTest
{
    /**
     * @group routerTest
     */
    public function testItGenerateUrlForSimpleRoute(){
        $route = Route::get("bar/","bar","");
        $parser = new RouteParser($route);
        $this->assertEquals("/bar",$parser->generateUrl());
    }
    /**
     * @group routerTest
     */
    public function testItGenerateUrlWithParameters(){
        $route = Route::get("bar/{id:\d+}-{slug:[a-z\-]+}","bar","");
        $parser = new RouteParser($route);
        $this->assertEquals("/bar/47-aze-aze",$parser->generateUrl(["id"=>"47","slug"=>"aze-aze"]));
    }

    /**
     * @group routerTest
     */
    public function testItGenerateUrlWithRouteGroup(){
        $route = Route::get("bar/{id:\d+}-{slug:[a-z\-]+}","bar","");
        $routeGroup = new RouteGroup("/foo/");
        $route->setRouteGroup($routeGroup);
        $parser = new RouteParser($route);
        $this->assertEquals("/foo/bar/47-aze-aze",$parser->generateUrl(["id"=>"47","slug"=>"aze-aze"]));
    }

    /**
     * @group routerTest
     */
    public function testItThrowIfThereIsMissingParametersWhenGeneratingRoute(){
        $route = Route::get("bar/{id:\d+}-{slug:[a-z\-]+}","bar","");
        $routeGroup = new RouteGroup("/foo/");
        $route->setRouteGroup($routeGroup);
        $parser = new RouteParser($route);
        $this->expectException(\InvalidArgumentException::class);
        $parser->generateUrl();
    }

}
