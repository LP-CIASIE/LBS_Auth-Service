<?php 

namespace lbs\auth\services;
use Firebase\JWT\JWT;

final class TokenService
{

    static public function insertToken($username)
    {
        $c = new \MongoDB\Client("mongodb://mongo.auth:27017");
        $db = $c->auth_service;
        $user = $db->users->findOne(['usermail' => $username]);

        $payload = [ 'iss'=>'http://auth.myapp.net',
                'aud'=>'http://api.myapp.net',
                'iat'=>time(), 'exp'=>time()+3600,
                'uid' => $user->_id,
                'lvl' => $user->userlevel,] ;

                
        $token = JWT::encode( $payload, random_bytes(64), 'HS512' );
        $refreshToken = $user->refresh_token;


        return(['access' => $token, 'refresh' => $refreshToken ]);
            
        
    }
}
