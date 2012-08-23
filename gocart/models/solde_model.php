<?php

class Solde_model extends CI_Model {
	
 	function __construct()
    {
        parent::__construct();
    }
    
	public function _getSoldeStatusData()
	{
		$q_solde = $this->db->query('SELECT * FROM en_soldes WHERE en_soldes_ID = 1');
		
		if ($q_solde->num_rows() > 0)
		{
			foreach ($q_solde->result() as $row)
		   	{
		    	$sale_status_data = array(
		   			'enum_solde' => $row->inititate_en_soldes,
		   			'percent_solde' => $row->per_reduct_en_soldes,
		   			'message_solde_fr' => $row->message_en_soldes_fr,
		   			'message_solde_en' => $row->message_en_soldes_en
		   		);
		   	}
		}
		else 
		{
			$sale_status_data = array();
		}
		
		$q_solde->free_result();
		
		return $sale_status_data;
	}	
}