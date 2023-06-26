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
 * )
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
