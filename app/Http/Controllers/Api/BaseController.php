<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller{
    public function sendResponse($response, $code=200, $status="Success"){
        return response()->json(['Data'=>$response, 'Status'=>$status], $code);
    }
}