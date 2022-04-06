<?php

namespace App\Models;

use CodeIgniter\Model;

class LikeModel extends Model
{

	protected $table         = 'likes';
	protected $primaryKey    = 'id';
	protected $allowedFields = [];
  


   public function getCountLikes(){

 
	 return $this->builder->selectCount('lik_fk_usu'); 

   }


}
