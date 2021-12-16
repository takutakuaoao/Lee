<?php

declare(strict_types=1);

namespace Lee;

if (!\function_exists('Lee\\makeString')) {
    function makeString(int $count, string $character = 'a')
    {
        $string = '';

        for ($i = 0; $i < $count; $i++) {
            $string .= $character;
        }

        return $string;
    }
}

if (!\function_exists('Lee\\snakeUpperCase')) {
    function snakeUpperCase($str)
    {
        return strtoupper(underscore($str));
    }
}

if (!\function_exists('Lee\\underscore')) {
    function underscore($str)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', '_\0', $str)), '_');
    }
}
