 <?php
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
	class IO_model extends CI_Model
	{
		public function retour($id)
		{
			$where = "ID = " . $id;
			
			$data = $this->getShortEmpruntById ( $id )->row_array ();
			$data ['dateRetour'] = date ( "Y-m-d H:i:s" );
			
			return $this->db->update ( 'emprunt', $data, $where );
		}
		public function getListEmpruntOnly()
		{
			return $this->db->get_where ( 'V_Emprunt', array (
					"dateRetour" => null ) );
		}
		public function getListEmprunt()
		{
			return $this->db->get ( 'V_Emprunt' );
		}
		public function getListEmpruntEnCoursByLivreId($id)
		{
			return $this->db->get_where ( 'V_Emprunt', array (
					"IDLivre" => $id,
					"dateRetour" => null ) );
		}
		public function getShortEmpruntById($id)
		{
			return $this->db->get_where ( 'emprunt', array (
					'ID' => $id ), 1 );
		}
		public function getEmpruntById($id)
		{
			return $this->db->get_where ( 'V_Emprunt', array (
					'ID' => $id ), 1 );
		}
		public function getListeEmpruntByWhere($field, $value)
		{
			return $this->db->query ( "SELECT * FROM V_Emprunt WHERE " . $field . " LIKE '%" . $value . "%';" );
		}
		public function addEmprunt($idLivre, $idUtilisateur, $duree = 30)
		{
			return $this->db->insert ( 'emprunt', array (
					'IDLivre' => $idLivre,
					'IDUtilisateur' => $idUtilisateur,
					'dateEmprunt' => date ( "Y-m-d" ),
					'duree' => $duree ) );
		}
	}
	?>