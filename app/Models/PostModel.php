<?php

namespace App\Models;

use CodeIgniter\Model; 
use App\Models\HomeModel;

class PostModel extends Model
{
    
    protected $table         = 'tbpost';
    protected $primaryKey    = 'pst_pk_id';
    protected $returnType    = 'array';

    protected $allowedFields = [ 'pst_fk_usu',
                                 'pst_text',
                                 'pst_dt_pst' ];


   

    protected $db;


    public function __construct() 
    {
        parent::__construct(); // não esquecer de chamar construtor pai
        $this->db = \Config\Database::connect();
        $this->homeModel = new HomeModel();
    }


    public function getPostById(string $id){

        $builder = $this->builder();


        $builder->select('*');
      
        $builder->where("pst_pk_id", $id);
        $res = $builder->get()->getResult()[0]->pst_text; 

       return $res;

           
    }

    public function checkOwnership($pid, $uid) // 'checar' dono do post / verify post owner
    {
    
            $vpost = $this->where('pst_pk_id', $pid)
                          ->first();
                         
        if($vpost) {
                 
          return ($vpost['pst_fk_usu'] == $uid);
          
        } else {
            
            return false;
        }
        
    }

    public function getLikesPost($pid)
    {
            
        //quantidade total de likes no post 
              
        $builder = $this->builder('tblike l');

        $queryPostLikes =  $builder->select('count(*) as qtdlike')
                                   ->join('tbpost p ', 'l.lik_fk_post = p.pst_pk_id')
                                   ->where("p.pst_pk_id", $pid)
                                   ->get(); 

        return $queryPostLikes->getResult()[0]->qtdlike; 

                                                    
     }

     public function getUserLikesPost($pid, $uid) // pega quantidade de likes de um usuario em um post especifico
    {
            
               
        $builder = $this->builder('tblike l');
           
        $queryPostUserLikes =  $builder->select('count(*) as qtdlike')
                                       ->join('tbpost p '   , 'l.lik_fk_post = p.pst_pk_id')
                                       ->join('tbusuario u ', 'l.lik_fk_usu = u.usu_pk_id')
                                       ->where("u.usu_pk_id = $uid and p.pst_pk_id = $pid")
                                       ->get(); 
      
        
        return $queryPostUserLikes->getResult()[0]->qtdlike;

         
    }

 

     public function like($pid, $uid)  // metodo adicionar like no post especifico 
     {
        
        //to-do: so adicionar like caso o usuario nao tenha dado like ainda (like == 0 )
      
        if ($this->getUserLikesPost($pid, $uid) >= 1) {
                
            $qtdlikePost =  $this->getLikesPost($pid);

            return $qtdlikePost;

       } else {

            $builder = $this->builder('tblike');
            
            $data = [ 'lik_fk_post' => $pid,
                      'lik_fk_usu'  => $uid ];
            
            $builder->insert($data); //erro aqui
    
    
            $qtdlikePost = $this->getLikesPost($pid);

            echo $qtdlikePost;

       }


     }

     public function getAllByKeyword(string $keyword) : array // pesquisa por palavra chave na busca 
     {
 
        $res = $this->homeModel->like('texto', $keyword)
                               ->get()
                               ->getResult();

     
        return $res;
       
     }
      

                            
}
