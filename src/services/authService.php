<?php
namespace lbs\auth\services;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class LoginService
{

	static public function login($user){
		$c = new \MongoDB\Client("mongodb://mongo.auth:27017");
		$db = $c->auth_service;
		$userFind = $db->users->findOne(['usermail' => $user[0]]);

		if ($userFind == null){
			return false;
		}
		else{
			if (password_verify($user[1], $userFind->userpswd)){
				return true;
			}
			else{
				return false;
			}
		}



	}
	
}