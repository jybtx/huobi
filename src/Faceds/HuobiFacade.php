<?php

namespace Jybtx\HuoBiApi\Faceds;

use Illuminate\Support\Facades\Facade;

class HuobiFacade extends Facade
{
	
	protected static function getFacadeAccessor()
    {
        return 'HuobiApi';
    }
}