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

    public static function generateNearbyCoordinates($lat, $lng, $radiusInMeters = 50): array
    {
        // Konversi meter ke derajat (1 derajat ≈ 111,320 meter)
        $radiusInDegrees = $radiusInMeters / 111320;

        $u = rand() / getrandmax(); // random 0-1
        $v = rand() / getrandmax();
        $w = $radiusInDegrees * sqrt($u);
        $t = 2 * M_PI * $v;

        $x = $w * cos($t);
        $y = $w * sin($t);

        // Perbaiki untuk kurvatur bumi
        $newLat = $lat + $y;
        $newLng = $lng + $x / cos(deg2rad($lat));

        return [
            'latitude' => $newLat,
            'longitude' => $newLng,
        ];
    }
}
