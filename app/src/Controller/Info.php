<?php

declare(strict_types=1);

namespace App\Controller;

use App\Helper\JsonResponse;

use Pimple\Psr11\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class Info
{
    private const API_NAME = 'precios-gamer-v1-api-rest';

    private const API_VERSION = '1.0.0';

    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getPhp(Request $request, Response $response): Response
    {
        if($_SERVER['DEBUG']){
            phpinfo();
        }
    }

    public function getStatus(Request $request, Response $response): Response
    {
        if($_SERVER['DEBUG']){
            $this->container->get('db');
            $status = [
                'status' => [
                    'database' => 'OK',
                ],
                'api' => self::API_NAME,
                'version' => self::API_VERSION,
                'timestamp' => time(),
            ];
            return JsonResponse::withJson($response, (string) json_encode($status));
        }
    }
}