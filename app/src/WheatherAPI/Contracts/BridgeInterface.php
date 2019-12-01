<?php

namespace App\WheatherAPI\Contracts;

interface BridgeInterface
{
    public function getWeather(string $city);
}
