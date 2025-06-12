<?php

namespace RamdanRiawan;

class Jwt
{
    private function base64UrlEncode($data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode($data): false|string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

    static function generateJWT($payload, $secret, $expire_in_seconds = 3600)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

        // Tambahkan expired ke payload (exp dalam UNIX timestamp)
        $payload['exp'] = time() + $expire_in_seconds;

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));

        $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $secret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";
    }

    static function isValidJWT($jwt, $secret)
    {
        $parts = explode('.', $jwt);

        if (count($parts) !== 3) return false;

        [$base64UrlHeader, $base64UrlPayload, $base64UrlSignature] = $parts;

        $header = json_decode(base64_decode(strtr($base64UrlHeader, '-_', '+/')), true);
        $payload = json_decode(base64_decode(strtr($base64UrlPayload, '-_', '+/')), true);
        $signatureProvided = base64_decode(strtr($base64UrlSignature, '-_', '+/'));

        // Buat signature ulang
        $expectedSignature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $secret, true);

        // Cek signature cocok
        if (!hash_equals($expectedSignature, $signatureProvided)) {
            return false;
        }

        // Cek apakah expired
        if (isset($payload['exp']) && time() > $payload['exp']) {
            return false; // expired
        }

        return $payload; // valid dan belum expired
    }

    static function isJWTExpired($jwt)
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return true;
        }

        $payload = json_decode(self::base64UrlDecode($parts[1]), true);
        if (!isset($payload['exp'])) {
            return true; // dianggap expired jika tidak ada exp
        }

        return time() >= $payload['exp'];
    }
}
