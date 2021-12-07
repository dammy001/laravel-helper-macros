<?php

use Illuminate\Support\Str;

if (!Str::hasMacro('truncate')) {
    Str::macro(/**
     * @param int $length
     * @param string $text
     * @return array|string|string[]|null
     */        'truncate',
        function (int $length, string $text) {
            if ($length >= strlen($text)) {
                return $text;
            }
            return preg_replace("/^(.{1,{$length}})(\\s.*|$)/s", '\\1...', $text);
        }
    );
}

if (!Str::hasMacro('formatAmount')) {
    Str::macro(/**
     * @param int|float $amount
     * @param int $decimal
     * @return string
     */        'formatAmount',
        function ($amount, int $decimal) {
            return number_format(
                $amount,
                $decimal,
                '.',
                ''
            );
        }
    );
}
