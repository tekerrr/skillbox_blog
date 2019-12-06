<?php

/**
 * @param $array array
 * @param $key string
 * @param null $default
 * @return mixed|null
 */
function array_get(array $array, string $key, $default = null)
{
    foreach (explode('.', $key) as $item) {
        if (isset($array[$item])) {
            $array = $array[$item];
        } else {
            return $default;
        }
    }

    return $array;
}
