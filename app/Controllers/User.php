<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UserModel;

class User extends BaseController
{
  
       function __construct()
    {
        helper('form');
        $this->usuariosModel = new UserModel();
           
    }
           

    public function showProfile($uid) // load profile information and show on view / carrega informações do usuario e mostra na view 
    {
        
           if (!$uid) {
               
               throw new \CodeIgniter\Exceptions\PageNotFoundException("Link inexistente");
               
           }
           
        $userData = $this->usuariosModel->getById($uid);
        
     
       if ($userData) {
        
       echo view('profile/profile', ["userData" => $userData]); 
       
       } else {
           
              return redirect()->to('/');
       }
        
    }

}
