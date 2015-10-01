<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    
    function convierteFechaBDLetra($fecha,$idioma){

        $dia = substr($fecha,8,2);
        $mes = substr($fecha,5,2);
        $anio = substr($fecha,0,4);

        $meses_ing_letra=array("01"=>"January", "02"=>"February", "03"=>"March", "04"=>"April", "05"=>"May", "06"=>"June","07"=>"July", "08"=>"August", "09"=>"September", "10"=>"October", "11"=>"November", "12"=>"December");
        $meses_esp_letra=array("01"=>"Enero", "02"=>"Febrero", "03"=>"Marzo", "04"=>"Abril", "05"=>"Mayo", "06"=>"Junio","07"=>"Julio", "08"=>"Agosto", "09"=>"Septiembre", "10"=>"Octubre", "11"=>"Noviembre", "12"=>"Diciembre");
        
        
        switch($idioma) {
              case '1': $fecha_letra=$meses_ing_letra[$mes]." ".$dia.", ".$anio; break;
              case '2': $fecha_letra=$dia." de ".$meses_esp_letra[$mes]." de ".$anio; break;
        }
       
       return $fecha_letra;
       
    }
    
?>