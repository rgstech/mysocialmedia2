<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Util
 *
 * @author Rodrigo Guimarães
 * Classe com alguns metodos uteis
 */
namespace App\Libraries;

class Util {
    
       
   public static function formatDateTime($vdate){
        
            $data = new DateTime($vdate);
           // $data->setDate(1995, 3, 9);
          return  $data->format('d-m-Y H:i:s');
            
            
    }
    
    
    public static function formatDate($vdate){
        
            $data = new DateTime($vdate);
           // $data->setDate(1995, 3, 9);
      
            $parts = explode(' ',  $data->format('d/m/Y H:i:s'));
            $datePart = $parts[0];
            
            
          return  $datePart;
            
            
    }
    
     public static function retornoSexo($sexo){
        
        if (is_string($sexo)){
            
             $strSexo = "";
             $sexo == "m" ? $strSexo  = "masculino" : $strSexo = "feminino";
                       
             return $strSexo;
                                               
        } else {
            
          return "error!";
            
        }
        
    }
      
    
}
