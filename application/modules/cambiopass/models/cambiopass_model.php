<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cambioPass_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();	
	}
	
	
	function actualizaPass($pass, $hash, $email){
		$data = array(
               'contrasenia' => $pass,
               'hash' => $hash
            );
            
            $this->db->where('email', $email);
            $this->db->update('usuarios', $data); 
	
	return 1;
	//return $this->db->result();
	}
	
}
?>