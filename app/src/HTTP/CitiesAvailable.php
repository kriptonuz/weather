<?php
declare(strict_types=1);

namespace App\HTTP;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class CitiesAvailable implements RequestHandlerInterface
{
    /**
     * @var array
     */
    private $cities;

    public function __construct(array $citiesAvailable)
    {
        $this->cities = $citiesAvailable;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($this->cities);
    }
}
