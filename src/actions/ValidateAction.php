<?php

namespace lbs\auth\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use lbs\auth\services\utils\FormatterAPI as FormatterAPI;
use lbs\auth\services\TokenService as TokenService;

final class ValidateAction
{
  public function __invoke(Request $request, Response $rs): Response
  {
    $token = $request->getHeader('Authorization')[0];;

    $tokenService = new TokenService();

    try {
      $tokenService->verifyToken($token);

      $data = [
        'type' => 'success',
        'message' => 'Token valide',
      ];
      return FormatterAPI::formatResponse($request, $rs, $data, 200); // 200 = OK

    } catch (\Exception $e) {
      $data = [
        'type' => 'error',
        'error' => 401,
        'message' => $e->getMessage(),
      ];
      return FormatterAPI::formatResponse($request, $rs, $data, 401); // 401 = Unauthorized
    }
  }
}
