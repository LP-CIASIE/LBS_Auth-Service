<?php

namespace lbs\auth\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use lbs\auth\services\utils\FormatterAPI as FormatterAPI;
use lbs\auth\services\TokenService as TokenService;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;



final class ValidateAction
{
  public function __invoke(Request $request, Response $rs,): Response
  {
    function getTokenFromRequest(Request $request)
    {
      $header = $request->getHeader('Authorization')[0];
      if (empty($header)) {
        return null;
      } else {
        return $header;
      }
    }

    $token = getTokenFromRequest($request);
    $tokenService = new TokenService();
    $response = $tokenService->verifyToken($token);

    if ($response['data'] == 'error') {
      $data = [
        'type' => 'error',
        'error' => 401,
        'message' => 'Token invalide',
      ];
      return FormatterAPI::formatResponse($request, $response, $data, 401);
    } else {
      $request = $request->withAttribute('token', $response['token']);
      $data = [
        'type' => 'success',
        'message' => 'Token valide',
      ];
      return FormatterAPI::formatResponse($request, $response, $data, 201); 
    }
  }
}
