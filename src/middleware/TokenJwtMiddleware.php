<?php

namespace lbs\auth\middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;

class TokenJwtMiddleware
{
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $token = $this->getTokenFromRequest($request);

    if ($this->verifyToken($request, $token)) {
      $response = $handler->handle($request);
      return $response;
    } else {
      $response = new Response();
      $data = [
        'error' => "Token invalide ou manquant."
      ];
      $response->getBody()->write(json_encode($data));
      return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
    }
  }

  private function getTokenFromRequest(Request $request)
  {
    $header = $request->getHeader('access-token');
    if (empty($header)) {
      return null;
    } else {
      return $header[0];
    }
  }
  // Vérifier le decodage du token plus tester le décodage du token avec le setting.php
  private function verifyToken(Request $request, $token)
  {
    $params = require __DIR__ . '/../../data/settings.php';
    $secret = $params['JWT_SECRET'];
      var_dump($token);
      die;
    if (empty($token)) {

      return false;
    } else {
      $header = $request->getHeader('Authorization')[0];

      $tokenstring = sscanf($header, "Bearer %s");
      $token = JWT::decode($tokenstring, new Key($secret, 'HS512'));
    }
  }
}
