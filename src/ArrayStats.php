<?php /** @noinspection ALL */

/**
 * Created by PhpStorm.
 * User: umutcelik
 * Date: 2019-01-12
 * Time: 18:17
 */

namespace ArrayStatistics;

use JsonSerializable;

function BlackScholes($call_put_flag, $S, $X, $T, $r, $v)
{

    $d1 = (log($S / $X) + ($r + pow($v, 2) / 2) * $T) / ($v * pow($T, 0.5));

    $d2 = $d1 - $v * pow($T, 0.5);

    if ($call_put_flag == 'c') {

        return $S * CND($d1) - $X * exp(-$r * $T) * CND($d2);

    } else {

        return $X * exp(-$r * $T) * CND(-$d2) - $S * CND(-$d1);

    }
}

class ArrayStats
{
    private $array = [];

    /**
     * ArrayCalculator constructor. Please dont pass empty array.
     * @param array $array
     * @throws \Exception
     */
    public function __construct(Array $array = [])
    {
        if (count($array) === 0) {
            throw new \Exception("Array can not be empty", "100");
        }
        $this->array = array_map('floatval', array_values($array));
        rsort($this->array);
    }

    /**
     * @return array
     */
    public function getArray(): Array
    {
        return $this->array;
    }

    /**
     * @param array $array
     * @throws \Exception
     */
    public function setArray(array $array): void
    {
        if (count($array) === 0) {
            throw new \Exception("Array can not be empty", "100");
        }
        $this->array = array_map('floatval', array_values($array));
        rsort($this->array);
    }

    /**
     * Ortalama
     * @return float
     */
    public function mean(): float
    {
        return round(array_sum($this->array) / count($this->array), 2);
    }

    /**
     * Medyan
     * @return float
     */
    public function median(): float
    {
        $middle = round(count($this->array) / 2);
        return $this->array[$middle - 1];
    }

    /**
     * Mod
     * @return float
     */
    public function mode(): float
    {
        $v = array_count_values(array_map(function (float $value) {
            return "{$value}";
        }, $this->array));
        arsort($v);
        $total = null;
        foreach ($v as $k => $v) {
            $total = $k;
            break;
        }
        return $total;
    }

    /**
     * Ranj
     * @return float
     */
    public function range(): float
    {
        $array = $this->array;
        sort($array);
        $sml = $array[0];
        rsort($array);
        $lrg = $array[0];
        return $lrg - $sml;
    }

    /**
     * Standard Sapma
     * @return float
     */
    public function standard_deviation(): float
    {
        return stats_standard_deviation($this->array);
    }

    /**
     * Frekans
     * @return float
     */
    public function frequency(): float
    {
        $frequencies = [];
        foreach ($this->array as $item) isset($frequencies[$item]) ? $frequencies[$item]++ : $frequencies[$item] = 1;
        $max = (object)['key' => 0, 'val' => 0];
        foreach ($frequencies as $key => $frequency) if ($frequency > $max->val) {
            $max->key = $key;
            $max->val = $frequency;
        }
        return ($max->key / $max->val);
    }

    /**
     * Minimum
     * @return float
     */
    public function min(): float
    {
        return min($this->array);
    }

    /**
     * Maximum
     * @return mixed
     */
    public function max()
    {
        return max($this->array);
    }

    /**
     * @param int $min
     * @param int $max
     * @return array
     */
    public function graphData(int $min = 0, int $max = 100): array
    {
        $array = [];
        $mean = $this->mean();
        $standard_deviation = $this->standard_deviation();
        $dn = 0;
        for ($i = $min; $i <= $max; $i++) {
            if ($i < ($max/2)) $dn += $this->dens_normal($i, $mean, $standard_deviation);
            else $dn -= $this->dens_normal($i, $mean, $standard_deviation);
            $array[] = new GraphItem($i, $dn >= 0 ? $dn : 0);
        }
        return $array;
    }

    /**
     * @param $i
     * @param $mean
     * @param $standard_deviation
     * @return float
     */
    public function dens_normal($i, $mean, $standard_deviation): float
    {
        return stats_dens_normal($i, $mean, $standard_deviation);
    }
}

class GraphItem implements JsonSerializable
{
    private $item;

    public function __construct(string $name, float $value)
    {
        $this->item = (object)[
            'name' => $name,
            'value' => round($value, 2)
        ];
    }

    public function jsonSerialize()
    {
        return $this->item;
    }
}