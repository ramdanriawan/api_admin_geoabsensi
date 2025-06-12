<?php

namespace RamdanRiawan;

use Illuminate\Support\Str;
use stdClass;

class StrManipulate
{
    public static function makeCase(string $str)
    {
        $stdClass = new StdClass();

        $stdClass->pascal = Str::pascal($str);
        $stdClass->camel = Str::camel($str);
        $stdClass->upper = Str::upper($str);
        $stdClass->lcfirst = Str::lcfirst($str);
        $stdClass->ucwords = ucwords($str);

        return $stdClass;
    }
}
