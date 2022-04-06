<?php 

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Config\Services;
use Firebase\JWT\JWT;

class AuthJwt extends ResourceController //  controller para autenticação via JWT / controller to autenticate using JWT
{

    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function login() // executa login autenticando o usuario na base e retornando um token(JWT)
    {                       // login and return a token (using JWT)
        
		/**
		 * JWT claim types
		 * https://auth0.com/docs/tokens/concepts/jwt-claims#reserved-claims
		 */
    
        $json = $this->request->getJSON(); 
         
          $email    = $json->email;
	      $password = $json->password; 
         
        $dadosUsuario = $this->model->getByEmail($email); 
        
        if (count($dadosUsuario) > 0) 
        {
            
            $hashUsuario = $dadosUsuario['usu_senha'];
           
            if(password_verify($password, $hashUsuario))
            {
                     
                $key = Services::getSecretKey(); 
                
                $issuedAtTime    = time();
                $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
                $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    
                $payload = [ 'email' => $email,
                             'iat'   => $issuedAtTime,
                             'exp'   => $tokenExpiration ];
                
                 $jwt = JWT::encode($payload, $key);
                        
		            return $this->respond( ['token' => $jwt], 200 );
                        
            }  else {
                
                return $this->respond(['message' => 'Invalid login details'], 401);

            }
                        
	      }

		return $this->respond(['message' => 'Invalid login details'], 401);
	}
}
