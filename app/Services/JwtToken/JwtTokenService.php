<?php


namespace App\Services\JwtToken;

use App\Models\User;
use RamdanRiawan;
use RamdanRiawan\Jwt;

class JwtTokenService
{
    static function tokenArray($token)
    {
        return [
            'access_token' => $token,
            'jwt_token' => Jwt::generateJWT([$token], '1q4wraesfdzx5qwsterdyfh123456', User::ACCESS_TOKEN_EXPIRED_IN_MINUTES * 60),
            'token_type' => 'bearer',
            'expires_in' => User::ACCESS_TOKEN_EXPIRED_IN_MINUTES
        ];
    }
}
