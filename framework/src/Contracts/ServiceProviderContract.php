<?php

namespace Oxygen\Contracts;

interface ServiceProviderContract
{
    public function register(AppContract $app);
}