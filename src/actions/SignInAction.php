<?php
namespace lbs\auth\actions;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use lbs\auth\services\utils\FormatterAPI as FormatterAPI;
use lbs\auth\services\TokenService as TokenService;

final class SignInAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        
        $tokenJWT = TokenService::insertToken($rq->getParsedBody()['usermail']);

        $data = [
            
            'access-token' => $tokenJWT['access'],
            'refresh-token' => $tokenJWT['refresh'],


        ];
        return FormatterAPI::formatResponse($rq, $rs, $data, 201); // 201 = Created
    }
}