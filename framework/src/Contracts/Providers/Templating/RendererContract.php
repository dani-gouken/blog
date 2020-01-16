<?php

namespace Oxygen\Contracts\Providers\Templating;

interface RendererContract
{
    public function render($template, array $args = []);
}