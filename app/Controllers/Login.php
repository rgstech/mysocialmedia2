<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Login extends BaseController
{
	 
    function __construct() 
    { 
           helper('form');
    }
    
    public function index() 
    {
        if (session()->isLoggedIn == true) { //se ja tive logado vai para home / if user is already logged go to home page

			return redirect()->to('/');
            
		} else {

            return view("login");
        }
        
    }
    
    public function signIn() //metodo singin para logar no sistema por sessão
    {
     
        $email    = $this->request->getPost('inputEmail');
        $password = $this->request->getPost('inputPassword');
        
        $usuarioModel = new UserModel();
     
        $dadosUsuario = $usuarioModel->getByEmail($email);
        
     
        if (count($dadosUsuario) > 0) 
        {
           
            $hashUsuario = $dadosUsuario['usu_senha'];
           
            if(password_verify($password, $hashUsuario)) 
            {
                
                session()->set('isLoggedIn', true); 
                session()->set('id',     $dadosUsuario['usu_pk_id']);
                session()->set('login',  $dadosUsuario['usu_login']);
                session()->set('nome',   $dadosUsuario['usu_nome']);
                session()->set('email',  $dadosUsuario['usu_email']);
                session()->set('tel',    $dadosUsuario['usu_tel']);
                session()->set('img',    $dadosUsuario['usu_img']);
                session()->set('dt_cad', $dadosUsuario['usu_dt_cad']);
                session()->set('sexo',   $dadosUsuario['usu_sexo']);
             
                return redirect()->to(base_url("/"));
               
           } else {
               
               session()->setFlashData('msg','Usuario ou senha incorretos!' );
               return redirect()->to('/login');
          
           } 
            
        } else {
           
            session()->setFlashData('msg','Usuario ou senha incorretos!' );
      
            return redirect()->to('/login');
        } 
        
    } 
    
    public function signOut() 
    {
        
        session()->destroy();
        return redirect()->to(base_url("usuario"));
        
    }
    
     
    
    
}
