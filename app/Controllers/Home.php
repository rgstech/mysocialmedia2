<?php
/* 

#Script desenvolvido por/Developed by Rodrigo Guimaraes
#Github: github.com/rgstech
#Rede social minimalista(mini rede social) 
#Minimalist Social Media/Netwok 
#Made and tested with codeigniter framework version: 4.1.1 
#License: GPL V2

*/
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\HomeModel;
//use App\Models\LikeModel; //not using at moment / nao utilizado atualmente
use App\Models\PostModel;
use App\Models\CommentModel;

// use Config\Services;
// use Firebase\JWT\JWT;
// use CodeIgniter\I18n\Time;

class Home extends BaseController
{

    protected $usuariosModel;
//  private   $likeModel;
    private   $postModel;

    function __construct()
    {

        helper('form');

        $this->usuariosModel = new UserModel();
        $this->homeModel     = new HomeModel();
     // $this->likeModel     = new LikeModel();
        $this->postModel     = new PostModel();
        $this->commentModel  = new CommentModel();
    }

    public function index()
    {

        return view('home',  [
            "posts"  =>  $this->homeModel->paginate(5),
            "pager"  =>  $this->homeModel->pager
        ]);
    }



    public function search()
    {
    
         //resolver csrf 
         $data   = $this->request->getPost();

         $keyword = $data['qsearch'];
         
         $s_users    = '';
         $s_posts    = '';
         $s_comments = '';

         if($keyword) {

             $s_users    =  $this->usuariosModel->getAllByKeyword($keyword);
             $s_posts    =  $this->postModel->getAllByKeyword($keyword);
             $s_comments =  $this->commentModel->getAllByKeyword($keyword);

        } 
         
         return view('search/search', ['users'    =>  $s_users,
                                       'posts'    =>  $s_posts,
                                       'comments' => $s_comments]);
    }
}
