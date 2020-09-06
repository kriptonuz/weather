<?php
declare(strict_types=1);

namespace App;

interface WheatherInterface
{
    public function getWeather(string $city);
}
