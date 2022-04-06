<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{

    protected $table      = 'tbusuario';
    protected $primaryKey = 'usu_pk_id';

    protected $allowedFields = [ 'usu_login',
                                 'usu_senha',
                                 'usu_nome',
                                 'usu_email',
                                 'usu_tel',
                                 'usu_img',
                                 'usu_dt_cad',
                                 'usu_sexo',
                                 'usu_bio' ];

                                 
    protected $db;                       


    public function getByEmail(string $email): array
    {

        $rq = $this->where('usu_email', $email)->first();

        return !is_null($rq) ? $rq : [];
    }


    public function getById(int $uid): array
    {

        $rq = $this->where('usu_pk_id', $uid)->first();

        return !is_null($rq) ? $rq : [];
    }


    public function getByNome(string $nome): array
    {

        $rq = $this->where('usu_email', $nome)->findAll();  //muda

        return !is_null($rq) ? $rq : [];
    }


    public function getPosts(int $uid): array //  retornar todos os posts desse usuario
    {

      // $user = $this->getById($uid);

        $builder = $this->builder('tbpost p');

        $res =  $builder->select('p.*, u.usu_nome')
                        ->join('tbusuario u', 'u.usu_pk_id = p.pst_fk_usu') // a tabela com a qual vai cruzar vem como argumento do join
                        ->where("p.pst_fk_usu", $uid)
                        ->get()
                        ->getResult();

        return $res; 

       
    }


    public function getAllByKeyword(string $keyword) : array
    {

        $builder = $this->builder('tbusuario');

        $res     =  $builder->select('usu_pk_id as uid,usu_nome as nome, usu_email as email, 
                                      usu_tel as tel, usu_img as img, 
                                      usu_dt_cad as cad, usu_sexo as sexo, usu_bio as bio  ')
                            ->like('usu_nome', $keyword)
                            ->get()
                            ->getResult();

       
        return $res;
      
    }

    
}
