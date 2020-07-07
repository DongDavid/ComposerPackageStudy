<h1 align="center"> 🌈基于高德开放平台的 PHP 天气信息组件 </h1>

<p align="center"> 基于高德开放平台的PHP天气查询组件</p>


## 安装 

```shell
$ composer require dongdavid/weather -vvv
```

## 配置  

在使用本扩展之前, 你需要取[高德开放平台](https://lbs.amap.com/dev/id/newuser)注册账号,  创建应用 , 获取应用的API Key  

## 使用  

```php
use Dongdavid\Weather\Weather;

$key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

$weather = new Weather($key);
```

### 获取实时天气  

```php
$response = $weather->getWeather('杭州');

$response = $weather->getLiveWeather('杭州');
```
示例:  

```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "lives": [
        {
            "province": "浙江",
            "city": "杭州市",
            "adcode": "330100",
            "weather": "阴",
            "temperature": "25",
            "winddirection": "西南",
            "windpower": "≤3",
            "humidity": "87",
            "reporttime": "2020-07-07 21:25:37"
        }
    ]
}
```

### 获取近期天气预报  

```php
$response = $weather->getWeather('杭州', 'all');

$response = $weather->getForecastsWeather('杭州');
```

示例:  

```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "forecasts": [
        {
            "city": "杭州市",
            "adcode": "330100",
            "province": "浙江",
            "reporttime": "2020-07-07 21:25:38",
            "casts": [
                {
                    "date": "2020-07-07",
                    "week": "2",
                    "dayweather": "阴",
                    "nightweather": "中雨-大雨",
                    "daytemp": "28",
                    "nighttemp": "24",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2020-07-08",
                    "week": "3",
                    "dayweather": "中雨-大雨",
                    "nightweather": "暴雨",
                    "daytemp": "27",
                    "nighttemp": "24",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2020-07-09",
                    "week": "4",
                    "dayweather": "中雨",
                    "nightweather": "小雨-中雨",
                    "daytemp": "28",
                    "nighttemp": "24",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2020-07-10",
                    "week": "5",
                    "dayweather": "小雨",
                    "nightweather": "小雨",
                    "daytemp": "30",
                    "nighttemp": "24",
                    "daywind": "西南",
                    "nightwind": "西南",
                    "daypower": "5",
                    "nightpower": "5"
                }
            ]
        }
    ]
}
```  

### 获取XML格式返回值  

```php
$response = $weather->getWeather('杭州', 'all', 'xml');
```

示例:  

```xml
<?xml version="1.0" encoding="UTF-8"?>
<response>
	<status>1</status>
	<count>1</count>
	<info>OK</info>
	<infocode>10000</infocode>
	<lives type="list">
		<live>
			<province>浙江</province>
			<city>杭州市</city>
			<adcode>330100</adcode>
			<weather>阴</weather>
			<temperature>25</temperature>
			<winddirection>西南</winddirection>
			<windpower>≤3</windpower>
			<humidity>87</humidity>
			<reporttime>2020-07-07 21:25:37</reporttime>
		</live>
	</lives>
</response>
```
### 参数说明  

```php
array|string getWeather(string $city, string $type = 'base', string $format = 'json')
```
> - `$city` - 城市名/[高德地址位置 adcode](https://lbs.amap.com/api/webservice/guide/api/district)，比如：“杭州” 或者（adcode：440300）；
> - `$format`  - 输出的数据格式，默认为 json 格式，当 output 设置为 “`xml`” 时，输出的为 XML 格式的数据。

### 在 Laravel 中使用

在 Laravel 中使用也是同样的安装方式，配置写在 `config/services.php` 中：

```php
    .
    .
    .
     'weather' => [
        'key' => env('WEATHER_API_KEY'),
    ],
```

然后在 `.env` 中配置 `WEATHER_API_KEY` ：

```env
WEATHER_API_KEY=xxxxxxxxxxxxxxxxxxxxx
```

可以用两种方式来获取 `Overtrue\Weather\Weather` 实例：

#### 方法参数注入

```php
    .
    .
    .
    public function edit(Weather $weather) 
    {
        $response = $weather->getLiveWeather('深圳');
    }
    .
    .
    .
```

#### 服务名访问

```php
    .
    .
    .
    public function edit() 
    {
        $response = app('weather')->getLiveWeather('深圳');
    }
    .
    .
    .

```

## 参考  

[高德开放平台天气接口](https://lbs.amap.com/api/webservice/guide/api/weatherinfo/)


## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/dongdavid/weather/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/dongdavid/weather/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT