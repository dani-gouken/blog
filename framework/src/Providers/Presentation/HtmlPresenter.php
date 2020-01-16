<?php


namespace Oxygen\Providers\Presentation;


class HtmlPresenter extends AbstractHtmlPresenter
{
    public static function present(
        string $template,
        array $data = [],
        int $statusCode = 200 ,
        array $headers = []
    ){
        return new self($template,$data,$statusCode,$headers);
    }

}