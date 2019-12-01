<?php

namespace App\HTTP;

use App\WheatherAPI\Contracts\BridgeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class City implements RequestHandlerInterface
{


    /**
     * @var BridgeInterface
     */
    private $api;

    public function __construct(BridgeInterface $api)
    {
        $this->api = $api;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $weather = $this->api->getWeather('tashkent');
        return new JsonResponse($weather, 200, ['Access-Control-Allow-Origin' => '*']);
    }
}
