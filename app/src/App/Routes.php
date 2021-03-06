<?php

declare(strict_types=1);

use Slim\Routing\RouteCollectorProxy;

// Info

if($_SERVER['DEBUG']){

    $app->group('/info', function (RouteCollectorProxy $groupInfo) {
        $groupInfo->get('/php', 'App\Controller\Info:getPhp');
        $groupInfo->get('/status', 'App\Controller\Info:getStatus');
    });

}