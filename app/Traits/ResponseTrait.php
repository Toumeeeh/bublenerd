<?php

namespace App\Traits;

use Tymon\JWTAuth\Facades\JWTAuth;

trait ResponseTrait{

    static function successWithMessage($messageHolder,$statusCode = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $messageHolder
        ], $statusCode);
    }

    static function successWithData($data,$messageHolder,$statusCode = 200)
    {
        return response()->json([
            'status' => true,
            'data' =>  $data,
            'message' => $messageHolder
        ],$statusCode);
    }

    static function userWithToken($user,$token)
    {
        $user->access_token = $token;
        $user->token_type =  'bearer';
        $user->expires_in = JWTAuth::factory()->getTTL() ; //todo:
        return $user;
    }

    static function userToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' =>  'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() //todo:
        ]);
    }

    static function failed($messageHolder,$statusCode = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $messageHolder
        ],$statusCode);
    }


}
