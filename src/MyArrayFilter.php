<?php

declare(strict_types=1);

function my_array_filter(array $array, callable $callback = null, int $flag = 0): array
{
    $result = [];
    if (null === $callback) {
        foreach ($array as $key => $value) {
            if ($value) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    foreach ($array as $key => $value) {
        if (ARRAY_FILTER_USE_KEY === $flag) {
            if ($callback($key)) {
                $result[$key] = $value;
            }
        } else if (ARRAY_FILTER_USE_BOTH === $flag) {
            if ($callback($value, $key)) {
                $result[$key] = $value;
            }
        } else if ($callback($value)) {
            $result[$key] = $value;
        }
    }

    return $result;
}
