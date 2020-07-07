<?php
// 先引入自动加载
require __DIR__ . '/vendor/autoload.php';

use Dongdavid\Weather\Weather;

$key = 'de1589fbe01884a20cb9e6fa02ac6ffb';

$w = new Weather($key);

echo "获取实时天气: \n";

$response = $w->getWeather('杭州');

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

echo "\n\n获取天气预报: \n";

$response = $w->getWeather('杭州','all');

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

echo "\n\n获取实时天气(XML)：\n";

echo $w->getWeather('杭州', 'base', 'XML');