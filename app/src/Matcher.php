<?php
declare(strict_types=1);

namespace App;

use App\HTTP\Accu;
use App\HTTP\CitiesAvailable;
use App\HTTP\City;
use App\HTTP\CityMustBeAvailble;
use App\HTTP\Hello;
use App\HTTP\NotFound;
use App\HTTP\OpenWheatherMap;
use Cekta\Routing\Nikic\DispatcherBuilder;
use Cekta\Routing\Nikic\Handler;
use Cekta\Routing\Nikic\ProviderHandler;
use Cekta\Routing\Nikic\ProviderMiddleware;

class Matcher extends \Cekta\Routing\Nikic\Matcher
{
    public function __construct(
        ProviderHandler $providerHandler,
        ProviderMiddleware $providerMiddleware
    ) {
        $builder = new DispatcherBuilder();
        $builder->get('/', Hello::class);
        $builder->get('/city/{city:\w+}', City::class, CityMustBeAvailble::class);
        $builder->get('/cities', CitiesAvailable::class);
        $builder->get('/accu/{city:\w+}', Accu::class, CityMustBeAvailble::class);
        $builder->get('/open/{city:\w+}', OpenWheatherMap::class, CityMustBeAvailble::class);
        parent::__construct(
            new Handler(NotFound::class),
            $builder->build(),
            $providerHandler,
            $providerMiddleware
        );
    }

}
