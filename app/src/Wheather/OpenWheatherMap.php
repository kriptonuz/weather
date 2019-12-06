<?php
declare(strict_types=1);

namespace App\Wheather;

use Cmfcmf\OpenWeatherMap;

class OpenWheatherMap
{
    /**
     * @var OpenWeatherMap
     */
    private $api;

    public function __construct(OpenWeatherMap $api)
    {
        $this->api = $api;
    }

    public function getWeather(string $city)
    {
        return $this->parse(json_decode($this->api->getRawHourlyForecastData($city, 'metric', 'en', '', 'json')));
    }

    private function parse($data)
    {
        $result = [];
        $result['city'] = $data->city->name;
        foreach ($data->list as $list) {
            $result['weather'][] = [
                'id' => $list->weather[0]->id,
                'time' => $list->dt,
                'title' => $list->weather[0]->main,
                'description' => $list->weather[0]->description,
                'temp' => round($list->main->temp),
                'icon' => $list->weather[0]->icon,
            ];
        }
        return $result;
    }
}
