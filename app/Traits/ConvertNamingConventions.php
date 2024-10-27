<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait ConvertNamingConventions
{
    function convertRequestJsonToSnakeCase($array): Request
    {
        $new_array = [];
        foreach ($array as $key => $value) {
            $new_array[Str::snake($key)] = $value;
        }
        
        $newRequest = new Request();
        $newRequest->replace($new_array);

        return $newRequest;
    }
}