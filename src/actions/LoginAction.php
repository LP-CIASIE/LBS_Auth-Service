<?php
namespace lbs\auth\actions;

use lbs\auth\services\LoginService;
use lbs\auth\services\utils\FormatterAPI;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class LoginAction
{
	public function __invoke(Request $rq, Response $rs): Response
	{
        $header = $rq->getHeaders();
        if(LoginService::login($header['usermail'], $header['userpswd'])){


            $data = [
            
                'Authorization' => 'Basic ' . base64_encode($header['username'] . ':' . $header['password']),
    
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 200); 
        }  
    }
}