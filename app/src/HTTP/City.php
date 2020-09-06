<?php

namespace App\HTTP;

use App\WheatherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class City implements RequestHandlerInterface
{
    /**
     * @var WheatherInterface
     */
    private $wheather;

    private $cities;

    public function __construct(WheatherInterface $api, array $citiesAvailable)
    {
        $this->wheather = $api;
        $this->cities = $citiesAvailable;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(
            $this->wheather->getWeather($request->getAttribute('city')),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}
