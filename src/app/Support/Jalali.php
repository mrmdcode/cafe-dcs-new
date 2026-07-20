<?php

namespace App\Support;

use Carbon\Carbon;

class Jalali
{
    /**
     * Convert a Gregorian date to a Jalali (Shamsi) date string.
     */
    public static function toJalali(Carbon|string $date, string $format = 'Y/m/d'): string
    {
        $date = $date instanceof Carbon ? $date : Carbon::parse($date);

        [$jy, $jm, $jd] = self::gregorianToJalaliParts((int) $date->format('Y'), (int) $date->format('n'), (int) $date->format('j'));

        return str_replace(
            ['Y', 'm', 'd', 'H', 'i', 's'],
            [$jy, str_pad((string) $jm, 2, '0', STR_PAD_LEFT), str_pad((string) $jd, 2, '0', STR_PAD_LEFT), $date->format('H'), $date->format('i'), $date->format('s')],
            $format
        );
    }

    private static function gregorianToJalaliParts(int $gy, int $gm, int $gd): array
    {
        $gDaysCumulative = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];

        $gy2 = $gm > 2 ? $gy + 1 : $gy;
        $days = 355666 + (365 * $gy) + intdiv($gy2 + 3, 4) - intdiv($gy2 + 99, 100)
            + intdiv($gy2 + 399, 400) + $gd + $gDaysCumulative[$gm - 1];

        $jy = -1595 + (33 * intdiv($days, 12053));
        $days %= 12053;
        $jy += 4 * intdiv($days, 1461);
        $days %= 1461;
        if ($days > 365) {
            $jy += intdiv($days - 1, 365);
            $days = ($days - 1) % 365;
        }

        if ($days < 186) {
            $jm = 1 + intdiv($days, 31);
            $jd = 1 + ($days % 31);
        } else {
            $jm = 7 + intdiv($days - 186, 30);
            $jd = 1 + (($days - 186) % 30);
        }

        return [$jy, $jm, $jd];
    }
}
