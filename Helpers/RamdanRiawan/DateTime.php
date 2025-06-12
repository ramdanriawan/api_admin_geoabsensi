<?php
namespace RamdanRiawan;

use Carbon\Carbon;

class DateTime
{

    public static function getDetailFlexible($time)
    {
        // Coba parse dengan H:i:s
        if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
            return self::getDetail('H:i:s', $time);
        }

        // Coba parse dengan H:i
        if (preg_match('/^\d{2}:\d{2}$/', $time)) {
            return self::getDetail('H:i', $time);
        }

        // Fallback: return null atau error
        return null;
    }
    public static function getDetail($format = "Y-m-d H:i:s", $value = null)
    {

        if ($value == null) {
            $value = date($format);
        }

        $carbon = Carbon::createFromFormat($format, $value);

        $hourString   = $carbon->hour < 10 ? "0$carbon->hour" : "$carbon->hour";
        $minuteString = $carbon->minute < 10 ? "0$carbon->minute" : "$carbon->minute";

        return [
            'hour'                      => $carbon->hour,
            'hour_string'               => (String) $hourString,
            'minute'                    => $carbon->minute,
            'minute_string'             => (String) $minuteString,
            'hour_minute_string'        => $hourString . ":" . $minuteString,
            "year_month_date"           => $carbon->translatedFormat('Y-m-d'),
            "year_month"                => $carbon->translatedFormat('Y-m'),
            "year"                      => $carbon->translatedFormat('Y'),
            "month"                     => $carbon->translatedFormat('m'),
            "month_year_human"          => $carbon->translatedFormat('F Y'),
            "day_date_month_year_human" => $carbon->translatedFormat('l, d F Y'),
            "day_date_month_human"      => $carbon->translatedFormat('l, d F'),
            "date_month_human"          => $carbon->translatedFormat('d F'),
            "day_time"                  => $carbon->translatedFormat('l, H:i'),
            "timezone"                  => config('app.timezone'),
        ];
    }
}
