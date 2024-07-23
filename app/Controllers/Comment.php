<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CommentModel;
use CodeIgniter\I18n\Time;


class Comment extends BaseController
{

  private $db;
  private $session;
  private $commentModel;



    function __construct() 
    {
           helper('form');
           $this->db = \Config\Database::connect();
           $this->session = session();
           
           $this->commentModel =  new CommentModel();
           
    }
    
    
    
    public function show($pid = null) 
    {
     
        
           if (!$pid) {
               
               throw new \CodeIgniter\Exceptions\PageNotFoundException("Link inexistente");
               
           }
            $builder = $this->db->table('tbpost p');
            
            $builder->select('p.pst_pk_id as pid, p.pst_text as texto, 
                              p.pst_dt_pst as data, u.usu_pk_id  as uid, 
                              u.usu_nome   as nome, 
                              u.usu_img    as image');
            
            $builder->join('tbusuario u ', 'p.pst_fk_usu = u.usu_pk_id');
            
            $builder->where("p.pst_pk_id = $pid");
            
            $queryPost = $builder->get(); 

           //*******************************************************************************************************         
     
            $builder = $this->db->table('tbcomment c');
            
            $builder->select('c.com_pk_id  as cid,   
                              c.com_text   as texto,
                              c.com_dt_com as data,
                              u.usu_pk_id  as uid,
                              u.usu_nome   as nome,
                              u.usu_img    as image, 
                            ( select count(*) from tblike l2
                              where l2.lik_fk_com = c.com_pk_id ) as qtdlike');

            $builder->join('tbpost p', 'p.pst_pk_id = c.com_fk_pst');
            
            $builder->join('tbusuario u', 'c.com_fk_usu = u.usu_pk_id');
            
            $builder->where("p.pst_pk_id = $pid");
            
            $queryComments = $builder->get();
          //*********************************************************************************************************
              
            $post     = $queryPost->getResult();
            $comments = $queryComments->getResult();
             
     
        return view('comments/comments' ,  [ 'post'     => $post[0],
                                             'comments' => $comments]);
        
    }



    public function save() //save or edit comment / salva ou edita um comentário
    {
        //regra so pode editar se o comment pertencer ao usuario, usar session->get('id') com com_fk_usu
        
         $data   = $this->request->getPost();
         
         $myTime = new Time('now', 'America/Recife', 'pt_BR');
        

        if ( isset($data["user_id"]) && session()->get('id') != $data["user_id"] ) { 
              
              return redirect()->to('/');
        }
          
     
        if (isset($data["com_id"]) && isset($data["text"])) { // update comment
            //a data(tempo) do comentário nao se altera para edição/atualização
              $dataToSave = [ "com_pk_id"  => $data["com_id"],
                              "com_text"   => $data["text"] ]; 
            
        } else if ( isset($data["user_id"]) && isset($data["post_id"]) && isset($data["text"]) ) {  // new comment
            
              $dataToSave = [ "com_fk_usu" => $data["user_id"],
                              "com_fk_pst" => $data["post_id"],
                              "com_text"   => $data["text"],
                              "com_dt_com" =>  ((array)$myTime)['date'] ]; 
        } else {
            
             throw new \CodeIgniter\Exceptions\PageNotFoundException("Dados de formulario inconsistentes");
            
        }

        $request = $this->commentModel->save($dataToSave);
        
          if ($request) {
         
               return redirect()->to('/comment/show/'. $data["post_id"]);
 
        } else {

            echo view('erro');
        }

    } 



   public function delete(int $cid = null, int $pid = null) // verificar dono do comentario antes de deletar e argumentos invalidos na rota
   {
       // localhost/ci4-apps/mysocialmedia2/comment/delete/58/21  (exemplo link delete)
       //                                              || /  /    
           if (!$cid && !$pid) {
               
               throw new \CodeIgniter\Exceptions\PageNotFoundException("Link inexistente");
               
           }
           
           
      if ( $this->commentModel->checkOwnership( $cid, session()->get('id') ) ){
       
          if ($this->commentModel->delete($cid)) {

              return redirect()->to('/comment/show/' . $pid );
          
          } else {
            
               return redirect()->to('/');
            
          } 
      }  else {
             return redirect()->to('/comment/show/' . $pid );
      }
        
    }



  public function edit($cid = null) 
  {
            
             if (!$cid) {
               
               throw new \CodeIgniter\Exceptions\PageNotFoundException("Link inexistente");
               
             }
           
             $comment = $this->commentModel->where('com_pk_id', (int)$cid)
                                           ->first();
             
             if(session()->get('id') == $comment['com_fk_usu']) {
                 
                 echo view('/common/edit', [ 'comment' => $comment ] );
                 
             } else {
                 
                 return redirect()->to('/');
                 
             }
             
          
            
        }
    
    
    
    public function like($cid, $uid) 
    {
        
       // verificar quantidade total de like para esse comentario 
       // verificar quantidade total de like do usuario para esse comentario
       // se usuario tem 1 ou mais likes para esse comentario entao retorna a quantidade total de likes do comentario
       //senao insere um like desse usuario nesse comentario e envia quantidade de likes atualizada como resposta 
                
       // quantidade de likes do usuario no comentario 
          if (!$cid && !$uid) {
               
               throw new \CodeIgniter\Exceptions\PageNotFoundException("Link inexistente");
               
           }
           

       if($uid != session()->get('id')) { 
               
                 $qtdlikeCom = $this->commentModel->getLikesCom($cid);

                 echo $qtdlikeCom;

                 return;
                 
        } else {

                $qtdlikeCom = $this->commentModel->like($cid, $uid);

                  echo $qtdlikeCom; 
           
                
               
           } 
           
           
        }

      
        
    
        
           
}  
