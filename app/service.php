<?php
declare(strict_types=1);

use Cmfcmf\OpenWeatherMap;
use GuzzleHttp\Client;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Factory\Guzzle\RequestFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

return [
    ContainerInterface::class => function (ContainerInterface $c) {
        return $c;
    },
    'citiesAvailable' => [
        'tashkent',
        'moscow',
        'london',
    ],
    OpenWeatherMap::class => function (ContainerInterface $container) {
        return new Cmfcmf\OpenWeatherMap(
            '36230ea21ba2b0906f0f53e2bded64e2',
            $container->get(ClientInterface::class),
            $container->get(RequestFactoryInterface::class)
        );
    },
    ClientInterface::class => function () {
        return GuzzleAdapter::createWithconfig([]);
    },
    RequestFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(RequestFactory::class);
    },
    Client::class => function () {
        return new Client();
    }
];
