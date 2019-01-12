<?php
/**
 * Created by PhpStorm.
 * User: umutcelik
 * Date: 2019-01-12
 * Time: 19:49
 */

// require_once __DIR__ . './../vendor/autoload.php';
require_once __DIR__ . './../src/ArrayStats.php';

use ArrayStatistics\ArrayStats;

$array = [30, 29, 28, 27, 27, 27, 26, 26, 26, 26, 25, 25, 24, 24, 22, 22, 22, 22, 21, 21, 20, 20, 20, 20, 19, 19, 19, 19, 18, 17, 17, 17, 17, 16, 16, 16, 16, 15, 15, 15, 15, 15, 14, 14, 14, 14, 14, 14, 14, 14, 13, 13, 13, 13, 13, 13, 13, 13, 12, 12, 12, 12, 12, 12, 12, 11, 11, 11, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 9, 9, 9, 9, 8, 8, 8, 8, 7, 7, 7, 7, 7, 7, 6, 6, 6, 5, 5, 4, 3, 0, 0, 0];
try {
    $arrayStats = new ArrayStats($array);
    print_r(json_encode((object)[
        "mean" => $arrayStats->mean(),
        "median" => $arrayStats->median(),
        "mode" => $arrayStats->mode(),
        "range" => $arrayStats->range(),
        "standard_deviation" => $arrayStats->standard_deviation(),
        "frequency" => $arrayStats->frequency(),
        "min" => $arrayStats->min(),
        "max" => $arrayStats->max(),
        "graphData" => $arrayStats->graphData(0, 30),
    ], JSON_PRETTY_PRINT));
    echo PHP_EOL;

} catch (Exception $e) {
    echo $e->getMessage();
}
