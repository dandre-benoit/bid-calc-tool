<?php

if (! function_exists('clamp')) {
    function clamp(float $value, float $min, float $max)
    {
        return max($min, min($max, $value));
    }
}

if (! function_exists('between')) {
    function between(float $value, array $ranges)
    {
        krsort($ranges);

        foreach ($ranges as $range => $fee) {
            if ($value > $range) {
                return $fee;
            }
        }

        return 0;
    }
}