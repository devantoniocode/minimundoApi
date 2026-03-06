<?php

namespace App\Responses;

use App\Exceptions\AlertException;

class Responses
{
    static function alert($message, $data = null)
    {
        throw new AlertException($message, $data);
    }
}
