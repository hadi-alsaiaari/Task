<?php

namespace App\Traits;

trait RandomCode
{
    public function generateRandomNumber($number)
    {
        $code = random_int(1, 9);
        for ($i = 0; $i < $number - 1; $i++)
            $code = $code * 10 + random_int(0, 9);
        return $code;
    }
}
