<?php
declare(strict_types=1);

namespace App\HTTP;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class Accu implements RequestHandlerInterface
{

    /**
     * @var array
     */
    private $cities;
    /**
     * @var \App\Wheather\Accu
     */
    private $wheather;

    public function __construct(\App\Wheather\Accu $accu, array $citiesAvailable)
    {
        $this->wheather = $accu;
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
