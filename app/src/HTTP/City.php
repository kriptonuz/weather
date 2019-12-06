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
        $city = $request->getAttribute('city');
        if (!in_array($city, $this->cities)) {
            return new JsonResponse(['City not Found'], 404, ['Access-Control-Allow-Origin' => '*']);
        }
        $weather = $this->wheather->getWeather($city);
        return new JsonResponse($weather, 200, ['Access-Control-Allow-Origin' => '*']);
    }
}
