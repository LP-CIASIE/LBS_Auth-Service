<?php 

namespace lbs\auth\services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class TokenService
{

    static public function createToken($username)
    {
        $c = new \MongoDB\Client("mongodb://mongo.auth:27017");
        $db = $c->auth_service;
        $user = $db->users->findOne(['usermail' => $username]);
        $data = require __DIR__ . '/../../data/settings.php';
        $secret = $data['JWT_SECRET'];
        $payload = [ 'iss'=>'http://auth.myapp.net',
                'aud'=>'http://api.myapp.net',
                'iat'=>time(), 'exp'=>time()+3600,
                'uid' => $user->_id,
                'lvl' => $user->userlevel,] ;

                
        $accessToken = JWT::encode( $payload, $secret, 'HS512' );
        $refreshToken = $user->refresh_token;


        return(['access' => $accessToken, 'refresh' => $refreshToken ]);
            
        
    }
    
    function verifyToken($token){

        if(empty($token)){
            $data = [
                'error' => "Token invalide ou manquant."
              ];
        }
        $params = require __DIR__ . '/../../data/settings.php';
        $secret = $params['JWT_SECRET'];
        $tokenDecoded = JWT::decode($token, new Key($secret, 'HS512'));
        var_dump($tokenDecoded);
        die;

      $data = [
        'token' => $tokenDecoded,
      ];
      $response->getBody()->write(json_encode($data));
      return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
    }
  
}
