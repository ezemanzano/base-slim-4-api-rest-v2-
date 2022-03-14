<?php 

declare (strict_types = 1);

namespace App\Controller;

use Pimple\Psr11\Container;

class Base{

    protected $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

}