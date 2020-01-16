<?php


namespace App\Modules\Front\Presentation;


use App\Services\Framework\AbstractTypes\AbstractHtmlPresenter;

class RenderHomePage extends AbstractHtmlPresenter
{
    protected $template = "index.php";
}