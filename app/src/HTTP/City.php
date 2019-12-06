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
    private BridgeInterface $api;

    private array $cities = [
        'tashkent',
        'moscow',
        'london',
    ];

    public function __construct(BridgeInterface $api)
    {
        $this->api = $api;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $city = $request->getAttribute('city');
        if (!in_array($city, $this->cities)) {
            return new JsonResponse(['City not Found'], 404, ['Access-Control-Allow-Origin' => '*']);
        }
        $weather = $this->api->getWeather($city);
        return new JsonResponse($weather, 200, ['Access-Control-Allow-Origin' => '*']);
    }
}
