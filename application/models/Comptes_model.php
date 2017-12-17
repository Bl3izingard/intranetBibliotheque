 <?php
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
	class Comptes_model extends CI_Model
	{
		public function getListeCompte()
		{
			return $this->db->get ( 'utilisateur' );
		}
		public function getListeCompteByWhere($field, $value)
		{
			return $this->db->query ( "SELECT * FROM utilisateur WHERE " . $field . " LIKE '%" . $value . "%';" );
		}
		public function getCompteById($id)
		{
			return $this->db->get_where ( 'utilisateur', array (
					'ID' => $id ), 1 );
		}
		public function addCompte($nom, $prenom, $adresse, $telephone, $mail, $civilite)
		{
			return $this->db->insert ( 'utilisateur', array (
					'nom' => $nom,
					'prenom' => $prenom,
					'adresse' => $adresse,
					'telephone' => $telephone,
					'mail' => $mail,
					'civilite' => $civilite ) );
		}
		public function deleteCompte($id)
		{
			return $this->db->delete ( 'utilisateur', array (
					'ID' => $id ) );
		}
		public function alterCompte($data)
		{
			$where = "ID = " . $data ['id'];
			
			$sql_data = array (
					'nom',
					'prenom',
					'adresse',
					'telephone',
					'mail',
					'civilite' );
			
			foreach ( $sql_data as $k => $r )
			{
				if (array_key_exists ( $k, $data ))
				{
					$sql_data [$k] = $data [$k];
				}
				else
				{
					unset ( $sql_data [$k] );
				}
			}
			
			return $this->db->update ( 'utilisateur', $data, $where );
		}
	}
	
	?>