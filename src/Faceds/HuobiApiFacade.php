<?php

namespace Jybtx\HuobiApi\Facades;

use Illuminate\Support\Facades\Facade;

class HuobiApiFacade extends Facade
{
	
	protected static function getFacadeAccessor()
    {
        return 'HuobiApi';
    }
}