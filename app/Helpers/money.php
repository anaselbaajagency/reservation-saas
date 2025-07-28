<?php

use Illuminate\Support\Number;

if (!function_exists('format_money')) {
    function format_money(float $amount, ?string $currency = null, int $decimals = 2): string
    {
        $formatted = Number::format($amount, $decimals);
        
        if ($currency) {
            return match(strtoupper($currency)) {
                'USD' => '$' . $formatted,
                'EUR' => '' . $formatted,
                'GBP' => '' . $formatted,
                default => $formatted . ' ' . strtoupper($currency),
            };
        }
        
        return $formatted;
    }
}
