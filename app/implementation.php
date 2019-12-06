<?php
declare(strict_types=1);

use App\Matcher;
use App\Wheather\Accu;
use App\WheatherInterface;
use Cekta\HTTP\Server\Application;
use Cekta\Routing\MatcherInterface;
use Psr\Http\Server\RequestHandlerInterface;

return [
    MatcherInterface::class => Matcher::class,
    RequestHandlerInterface::class => Application::class,
    WheatherInterface::class => Accu::class
];
