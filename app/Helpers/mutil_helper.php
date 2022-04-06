<?php

// Function: used to convert a string to revese in order
if (!function_exists("reverse_string")) 
{
    function reverse_string(string $string)
    {
        return strrev($string);
    }
}

if (!function_exists("formatDateTime")) 
{
  function formatDateTime($vdate){
        
          $data = new DateTime($vdate);
       // $data->setDate(1995, 3, 9);
          
          return  $data->format('d-m-Y H:i:s');
            
            
    }
}

if (!function_exists("formatDate")) 
{
    function formatDate($vdate) 
    {
        
            $data = new DateTime($vdate);
         // $data->setDate(1995, 3, 9);
      
            $parts = explode(' ',  $data->format('d/m/Y H:i:s'));
            $datePart = $parts[0];
            
            
          return  $datePart;
                    
    }
}


if (!function_exists("retornoSexo")) 
{
     function retornoSexo($sexo)
     {
        
        if (is_string($sexo))
        {
          
             $strSexo = "";
             $sexo == "m" ? $strSexo  = "masculino" : $strSexo = "feminino";
                       
             return $strSexo;
                                               
        } else {
            
          return "error!";
            
        }
        
    }
 } 