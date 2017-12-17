 <?php
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
	class Admin_model extends CI_Model
	{
		public function getListeEmploye()
		{
			return $this->db->get ( 'employe' );
		}
		public function getListeEmployeByWhere($field, $value)
		{
			return $this->db->query ( "SELECT * FROM employe WHERE " . $field . " LIKE '%" . $value . "%';" );
		}
		public function getEmployeById($id)
		{
			return $this->db->get_where ( 'employe', array (
					'ID' => $id ), 1 );
		}
		public function getNewUserList()
		{
			$data = $this->db->query ( "SELECT U.ID, U.Nom, U.Prenom FROM utilisateur AS U JOIN employe AS E ON U.ID = E.IDUtilisateur WHERE E.IDUtilisateur IS NULL" )->result ();
		
			$Array = array ();
			
			foreach ( $data as $row )
			{
				$Array [$row->ID] = $row->nom . " " . $row->prenom;
			}
		}
		
		public function getresponsableList()
		{
			$data = $this->db->get_where ( 'employe', array (
					"IDResponsable" => NULL ) )->result();
			
			$Array = array ();
			
			foreach ( $data as $row )
			{
				$Array [$row->IDUtilisateur] = $row->nom;
			}
			
			return $Array;
		}
		public function addEmploye($nom, $motDePasse, $IDSite, $IDResponsable)
		{
			return $this->db->insert ( 'employe', array (
					'nom' => $nom,
					'prenom' => $prenom,
					'adresse' => $adresse,
					'telephone' => $telephone,
					'mail' => $mail,
					'civilite' => $civilite ) );
		}
		public function deleteEmploye($id)
		{
			return $this->db->delete ( 'employe', array (
					'ID' => $id ) );
		}
		public function alterEmploye($data)
		{
			$where = "ID = " . $data ['id'];
			
			$sql_data = array (
					'nom',
					'motDePasse',
					'IDSite',
					'IDResponsable' );
			
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
			
			return $this->db->update ( 'employe', $data, $where );
		}
	}
	
	?>