<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *   title="AUTH API",
 *   version="1.0",
 * ),
 * @OA\SecurityScheme(
 * type="http",
 * description="Login with email and password to get the authentication token",
 * name="Token based Based",
 * in="header",
 * scheme="bearer",
 * bearerFormat="JWT",
 * securityScheme="bearerAuth",
 * ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function checkUser($item){
        if(auth('sanctum')->user()->name !== $item->author){
            throw new HttpResponseException(response()->json(['message' => "Unauthenticated",], 401));
        }
    }
}
