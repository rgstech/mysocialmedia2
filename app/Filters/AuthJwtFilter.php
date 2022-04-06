<?php

namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Firebase\JWT\JWT;
use Exception;

class AuthJwtFilter implements FilterInterface
{
    //Filtro para toda requisição a api para exigir um token previo para liberar a utilização a api
    //token obtido no login do controller AuthJwt
  	use ResponseTrait;

	public function before(RequestInterface $request, $arguments = NULL)
	{
	    $key        = Services::getSecretKey();
	    $authHeader = $request->getServer('HTTP_AUTHORIZATION');
            
            if (is_null($authHeader)) { //JWT is absent
                
                return Services::response()->setJSON( [ 'error' => 'no token provided or invalid token'])
                                           ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
                 
            }
            
            $arr   = explode(' ', $authHeader);
	        $token = $arr[1];
            
            try {
		       JWT::decode($token, $key, ['HS256']); //Verifica validade do token
                    //TO-DO: checar data de expiração aqui e invalidar se expirado
		} catch (\Exception $e) {
                    
		    return Services::response()->setJSON(['error' => 'no token provided or invalid token'])
                                               ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
                }
	
                
        }

	//--------------------------------------------------------------------

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = NULL)
	{
		// Do something here
	}
    
}
