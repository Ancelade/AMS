<?php

namespace App\Ams;

class GraphUtils
{
    public static function resampleInterpolatePoints(array $points, int $desiredPoints): array
    {
        if (empty($points) || $desiredPoints < 2) { // Need at least two points to form an interval
            return [];
        }

        // Sort points based on timestamps just in case they aren't in order
        usort($points, function ($a, $b) {
            return $a[0] <=> $b[0];
        });

        $sampledPoints = [];
        $startTime = $points[0][0];
        $endTime = end($points)[0];
        $totalDuration = $endTime - $startTime;

        // Calculate the interval between each point
        $interval = $totalDuration / ($desiredPoints - 1);

        for ($i = 0; $i < $desiredPoints; $i++) {
            $time = $startTime + $i * $interval;

            // Find two points between which the current time is
            for ($j = 0; $j < count($points) - 1; $j++) {
                if ($time >= $points[$j][0] && $time <= $points[$j + 1][0]) {
                    // Linear interpolation
                    $t1 = $points[$j][0];
                    $t2 = $points[$j + 1][0];
                    $v1 = $points[$j][1];
                    $v2 = $points[$j + 1][1];

                    // Calculate the interpolated value
                    $slope = ($v2 - $v1) / ($t2 - $t1);
                    $value = $v1 + ($time - $t1) * $slope;
                    $sampledPoints[] = [$time, round($value, 2)];
                    break;
                }
            }
        }

        return $sampledPoints;
    }

    public static function resamplePoints(array $points, int $targetCount): array
    {
        $sampledPoints = [];
        $totalPoints = count($points);

        // Assurer que la cible n'est pas supérieure au nombre de points existant
        $targetCount = $targetCount > $totalPoints ? $totalPoints : $targetCount;

        // Calculer l'intervalle d'échantillonnage
        if ($totalPoints === 0) {
            return [];
        }
        $interval = floor($totalPoints / $targetCount);

        for ($i = 0; $i < $totalPoints; $i += $interval) {
            // Ajouter le point à l'ensemble de sortie
            $sampledPoints[] = $points[$i];

            // Si on a atteint le nombre cible de points, arrêter la boucle
            if (count($sampledPoints) >= $targetCount) {
                break;
            }
        }

// S'assurer que le dernier point est toujours inclus
        if (count($sampledPoints) < $targetCount) {
            $sampledPoints[] = $points[$totalPoints - 1];
        }

        return $sampledPoints;
    }

    public static function incremental($data)
    {
        $lastpoint = null;
        $result = [];
        foreach ($data as $d) {
            if (!$lastpoint) {
                $lastpoint = $d[1];
                continue;
            }
            if ($lastpoint < $d[1]) {
                $result[] = [$d[0], $lastpoint + $d[1]];
            }
        }

        return $result;
    }

    public static function format($data)
    {

        $result = [];
        foreach ($data as $d) {
            $result[] = [$d[0], $d[1]];

        }
        return $result;
    }

    public static function negative($data)
    {
        $result = [];
        foreach ($data as $d) {
            $result[] = [$d[0], -$d[1]];

        }
        return $result;
    }

    public static function differencePositive($data)
    {
        $i = 1;
        $ia = 0;
        $dn = [];
        while (true) {
            if (!isset($data[$i])) {
                break;
            }
            $currentValue = $data[$i][1];
            $lastValue = $data[$i - 1][1];

            $currentTime = $data[$i][0];
            $lastTime = $data[$i - 1][0];

            $deltaSec = ($currentTime - $lastTime) / 1000;
            if ($currentValue > $lastValue) {
                $newValue = ($currentValue - $lastValue) / $deltaSec;
                $dn[$ia] = [$currentTime, $newValue];
            }


            $i++;
            $i++;
            $ia++;
        }

        return $dn;
    }

    public static function order($array)
    {
        usort($array, function ($a, $b) {
            return $a[0] - $b[0];
        });
        return $array;
    }

    public static function multiply(array $result_chart_in, $coef)
    {
        $result = [];
        foreach ($result_chart_in as $d) {
            $result[] = [$d[0], $d[1] * $coef];

        }
        return $result;
    }

}
