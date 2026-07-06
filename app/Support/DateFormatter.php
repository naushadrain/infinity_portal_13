<?php

namespace App\Support;

use Carbon\Carbon;
use Throwable;

class DateFormatter
{
    /**
     * Format a stored date value, tolerating ambiguous/non-ISO formats
     * (e.g. 'd/m/Y' without leading zeros) that crash Carbon::parse().
     */
    public static function safe(?string $value, string $format = 'd M Y'): string
    {
        if (!$value) {
            return '—';
        }

        try {
            return Carbon::parse($value)->format($format);
        } catch (Throwable) {
            foreach (['d/m/Y', 'm/d/Y', 'd-m-Y'] as $candidate) {
                try {
                    return Carbon::createFromFormat($candidate, $value)->format($format);
                } catch (Throwable) {
                    continue;
                }
            }

            return $value;
        }
    }
}
