<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Auths_model extends CI_Model {

        
        public function getUtilisateur($user)
        {
        	return $this->db->get_where('employe', array('nom' => $user), 1);
        }
        
        public function getListUser()
        {
        	$data = $this->db->get('utilisateur')->result();
        	
        	$userArray = array ();
        	
        	foreach ( $data as $row )
        	{
        		$userArray [$row->ID] = $row->nom . " " . $row->prenom;
        	}
        	
        	return $userArray;
        } 
        
}

?>