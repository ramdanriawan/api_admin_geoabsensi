<?php
namespace RamdanRiawan;

class Geolocator
{
    public static function distanceBetween($lat1, $lon1, $lat2, $lon2, $unit = 'km')
    {
        $radius = 6371; // Radius bumi dalam kilometer

        // Konversi derajat ke radian
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Rumus Haversine
        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;
        $a        = sin($deltaLat / 2) * sin($deltaLat / 2) +
        cos($lat1) * cos($lat2) *
        sin($deltaLon / 2) * sin($deltaLon / 2);
        $c     = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $jarak = $radius * $c;

        if ($unit == 'm') {
            return $jarak * 1000; // meter
        }

        return $jarak; // kilometer
    }
}
