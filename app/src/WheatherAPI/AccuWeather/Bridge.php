<?php

namespace App\WheatherAPI\AccuWeather;

use App\WheatherAPI\Contracts\BridgeInterface;
use GuzzleHttp\Client;

class Bridge implements BridgeInterface
{
    /**
     * @var Client
     */
    protected $httpClient;

    protected $token;

    protected const API_ENDPOINT = 'https://dataservice.accuweather.com/';

    private const CITY_ID = [
        'tashkent' => 351199,
        'moscow' => 294021,
        'london' => 328328,
    ];

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->token = 'mf6zSCSKxUVAD46e9a6xZMk5UY2lq7Xf';
//        $this->token = 'j5BGgYPbK4RwULffaswblKWWhGPzr3VG';
    }

    public function getWeather(string $city)
    {
        $city_id = $this->getCityId($city);
        $current  = $this->getCurrentWeather($city_id);
        $forecast = $this->getDailyForecast($city_id);

        return $this->parse($current, $forecast, $city);
    }

    protected function getDailyForecast(int $city_id)
    {
        return $this->request('forecasts/v1/daily/5day/', $city_id, ['metric' => 'true']);
    }

    protected function getCurrentWeather(int $city_id)
    {
        return $this->request('currentconditions/v1/', $city_id);
    }

    protected function request($method, $city_id, array $query = [])
    {
        $reponse = $this->httpClient->get(self::API_ENDPOINT . $method . $city_id, ['query' => array_merge([
            'apikey' => $this->token,
        ], $query)]);
        return json_decode($reponse->getBody());
    }

    protected function parse($raw_current_weather, $raw_forecast, $city)
    {
        $result = [];

        $result['city'] = ucfirst($city);

        $result['current'] = [
            'date' => $raw_current_weather[0]->EpochTime,
            'temp' => round($raw_current_weather[0]->Temperature->Metric->Value),
            'icon' => $raw_current_weather[0]->WeatherIcon,
            'phrase' => $raw_current_weather[0]->WeatherText,
        ];

        foreach ($raw_forecast->DailyForecasts as $forecast) {
            $result['forecast'][] = [
                'date' => $forecast->Date,
                'day' => [
                    'temp' => round($forecast->Temperature->Maximum->Value),
                    'icon' => $forecast->Day->Icon,
                    'phrase' => $forecast->Day->IconPhrase,
                ],
                'night' => [
                    'temp' => round($forecast->Temperature->Minimum->Value),
                    'icon' => $forecast->Night->Icon,
                    'phrase' => $forecast->Night->IconPhrase,
                ],
            ];
        }
        return $result;
    }

    protected function getCityId(string $city): int
    {
        return self::CITY_ID[$city];
    }
}
