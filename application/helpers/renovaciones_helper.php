<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    
    function marcaRenovaciones($fecha){
        
        $date = new DateTime($fecha);
		$date->add(new DateInterval('P11M'));
		$expira = $date->format('y-m-d');
		$today= date("y-m-d");
		
		if ($expira < $today){
		return 'yaExpiro';
        			
		}
       
    }
    
?>