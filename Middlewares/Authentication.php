<?php

namespace Middlewares;

use Commoms\Jwt;
use Exception;
use Interfaces\IMiddleware;


class Authentication implements IMiddleware
{
    private function __construct() {}
    private function __clone() {}
    static function init($tokenDb = null, $permissionsSystem = null, $permissionsUsers = null, $exp = 10)
    {
        $headers = [];
        $parsed = parse_ini_file('authentication.env');

        if (is_null($tokenDb)) {
            foreach (getallheaders() as $index => $value) {
                $headers[$index] = $value;
            }
            if (!isset($parsed["auth"]) || strlen(trim($parsed["auth"])) == 0) {
                throw new Exception("token file not found.", 500);
            }
            if (is_null($permissionsSystem) || is_null($permissionsUsers) || !isset($headers['Authorization'])) {
                throw new Exception("failed when trying to log in or authorize.", 401);
            }
            $token = str_replace("Bearer ", "", $headers['Authorization']);
        }else{
            $token = str_replace("Bearer ", "", $tokenDb);
        }
        $token = trim($token);
        $tokenDecode =  Jwt::decode($token, $parsed["auth"]);
        $isValidAcess = 0;
        foreach ($permissionsSystem as $index => $systemValue) {
            foreach ($permissionsUsers as $userValue) {
                if ($systemValue == $userValue) {
                    $isValidAcess++;
                }
            }
        }
        if ($isValidAcess == 0) {
            throw new Exception("failed when trying to log in or authorize.", 401);
        }
        if (!isset($tokenDecode["exp"]) || !isset($tokenDecode["user"]) || !isset($tokenDecode["level"])) {
            throw new Exception("poorly formatted token.", 401);
        }
        if ((strtotime(date("Y-m-d H:m:i")) - $tokenDecode['exp']) > $exp) {
            throw new Exception("failed when trying to log in or authorize.", 401);
        }
        return $tokenDecode;
    }
}
