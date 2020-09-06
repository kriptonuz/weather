<?php
declare(strict_types=1);

namespace App\HTTP;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class CityMustBeAvailble implements MiddlewareInterface
{
    /**
     * @var array
     */
    private $cities;

    public function __construct(array $citiesAvailable)
    {
        $this->cities = $citiesAvailable;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $city = $request->getAttribute('city');
        if (!in_array($city, $this->cities)) {
            return new JsonResponse(['City not Found'], 404, ['Access-Control-Allow-Origin' => '*']);
        }
        return $handler->handle($request);
    }
}
