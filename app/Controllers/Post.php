<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostModel;
use CodeIgniter\I18n\Time;
use App\Models\HomeModel;

class Post extends BaseController
{
    
    private $db;
    private $session;
    private $postModel;
    private $homeModel;



    function __construct() 
    {
              
            helper('form');
            
            $this->db = \Config\Database::connect();
    
            $this->session = session();
            
            $this->postModel = new PostModel();
            $this->homeModel = new HomeModel();
           
    }
    
    

    public function like($pid, $uid) 
    {
            //fetch('http://localhost/ci4-apps/mysocialmedia2/post/like/34/1').then(function(response) { console.log(response) }); //testar pelo browser  
            // verificar quantidade total de like para esse post 
            // verificar quantidade total de like do usuario para esse post
            // se usuario tem 1 ou mais likes para esse post entao retorna a quantidade total de likes do post
            //senao insere um like desse usuario nesse post e enviar quantidade de likes atualizada como resposta 
                
            // quantidade de likes do usuario no post 
          if ( !$pid && !$uid ) {
               
               throw new \CodeIgniter\Exceptions\PageNotFoundException("Link inexistente");
               
           }
         
           
          if($uid != session()->get('id')) { 
               
               $qtdlikePost = $this->postModel->getLikesPost($pid);

               echo $qtdlikePost;
                 
               return;
                 
          } else {

            $qtdlikePost = $this->postModel->like($pid, $uid);

               echo $qtdlikePost;
        

            } 
                 
    }



    public function save() 
    {
    
       // regra so pode editar se o post pertencer ao usuario usar session->get('id') com pst_fk_usu
       // se for atualização, pegar o id do post e nao salvar a data(manter data de criação antiga)
         $data   = $this->request->getPost();
         
              if ( !isset($data) || empty($data) ) {
               
               throw new \CodeIgniter\Exceptions\PageNotFoundException("Erro, dados de formulario vazio");
               
           } 
           
               
         $myTime = new Time('now', 'America/Recife', 'pt_BR');
        
          if ( isset($data["user_id"]) && session()->get('id') != $data["user_id"] ) {
              
              return redirect()->to('/');
          }
          
    
        if (isset($data["post_id"]) && isset($data["text"])) { //update post
            //a data do post nao se altera para edição/atualização
            $dataToSave = [ "pst_pk_id"  => $data["post_id"],
                            "pst_text"   => $data["text"]  ]; 
            
        } else if ( isset( $data["user_id"]) &&  $data["text"] ){  //new post
            
            $dataToSave = [ "pst_fk_usu" => $data["user_id"], 
                            "pst_text"   => $data["text"],
                            "pst_dt_pst" => ((array)$myTime)['date'] ]; 
        } else {

              return redirect()->to('/');

        }
       

        $request = $this->postModel->save($dataToSave);
        
          if ($request) {
         
               return redirect()->to('/');
 
        } else {

            echo view('erro');
        } 

    }



    public function delete(int $pid)// post id / pid
    {
        
         if (!$pid) {
               
               throw new \CodeIgniter\Exceptions\PageNotFoundException("Link inexistente");
             
           }
        
         if ( $this->postModel->checkOwnership( $pid, session()->get('id') ) ){
             if ($this->postModel->delete($pid)) {

                 return redirect()->to('/');
          
             } else {
            
                 return redirect()->to('/'); 
            
             }
          } else {

                 return redirect()->to('/');

           }
     }



     public function edit($pid)  // problema com tipo de retorno aqui!
     {
            
            if (!$pid) { 
               
               throw new \CodeIgniter\Exceptions\PageNotFoundException("Link inexistente");
               
           }
          
            $post = $this->postModel->where('pst_pk_id', (int)$pid)
                                    ->first();
             
            if(session()->get('id') == $post['pst_fk_usu']) {
                 
                 echo view('/common/edit', [ 'post' => $post ] );
                 
            } else {
                 
                 return redirect()->to('/');
                 
            }
                
      }



      public function userPosts($uid) //listar todos os posts de um usuario especifico / list all post from specific user
      { 
            
              if($uid != session()->get('id')) { 

                  return redirect()->to('/');

              }
          
             
            /*  $posts = $this->homeModel->where('uid', $uid) // trocar por home_view?
                                    ->findAll(); */
              
              echo view("profile/myposts",  [  "posts"  =>  $this->homeModel->where('uid', $uid)->paginate(5), //paginate com where
                                               "pager"  =>  $this->homeModel->pager ]);
                 
        }

    }
