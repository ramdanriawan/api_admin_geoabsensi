<?php

namespace RamdanRiawan;

class Accounting
{
    public static function formatRupiah($angka, $prefix = 'Rp ')
    {
        return $prefix . number_format($angka, 0, ',', '.');
    }
}
