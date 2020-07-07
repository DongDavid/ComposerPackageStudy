<?php 
namespace Dongdavid\Weather;

use GuzzleHttp\Client;
use  Dongdavid\Weather\Exceptions\InvalidArgumentException;
use  Dongdavid\Weather\Exceptions\HttpException;
/**
 * 
 */
class Weather
{
	protected $key;
	protected $guzzleOptions = [];

	public function __construct(string $key)
	{
		$this->key = $key;
	}

	public function getHttpClient()
	{
		return new Client($this->guzzleOptions);
	}


	public function setGuzzleOptions(array $options)
	{
		$this->guzzleOptions = $options;
	}

	public function getWeather($city, string $type = 'base', string $formate = 'json')
	{
		$url = 'https://restapi.amap.com/v3/weather/weatherInfo';

		if (!\in_array(\strtolower($formate), ['json','xml'])) {
			throw new InvalidArgumentException("Invalid response formate: ".$formate);
		}
		if (!\in_array(\strtolower($type), ['base', 'all'])) {
		    throw new InvalidArgumentException('Invalid type value(base/all): '.$type);
		}

		$query = array_filter([
			'key' => $this->key,
			'city' => $city,
			'output' => $formate,
			'extensions' => $type,
		]);
		try {
			$response = $this->getHttpClient()
								->get($url,['query'=>$query])
								->getBody()
								->getContents();
			return 'json' === $formate ? \json_decode($response, true) : $response;
		} catch (\Exception $e) {
			throw new HttpException($e->getMessage(), $e->getCode(), $e);
		}
		

	}
}