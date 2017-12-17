 <?php
	defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
	class Bibliotheque_model extends CI_Model
	{
		public function getListeLivre()
		{
			return $this->db->get ( 'V_Livre' );
		}
		public function getLivreById($id)
		{
			return $this->db->get_where ( 'V_Livre', array (
					'ID' => $id ), 1 );
		}
		public function getListeLivreByWhere($field, $value)
		{
			return $this->db->query ( "SELECT * FROM V_Livre WHERE " . $field . " LIKE '%" . $value . "%';" );
		}
		public function addLivre($titre, $resume, $courtResume, $IDSite, $IDType, $IDEditeur, array $IDGenre, array $IDAuteur)
		{
			$q1 = $this->db->insert ( 'livre', array (
					'titre' => $titre,
					'resume' => $resume,
					'courtResume' => $courtResume,
					'IDSite' => $IDSite,
					'IDType' => $IDType,
					'IDEditeur' => $IDEditeur ) );
			$insertID = $this->db->insert_id ();
			if ($insertID > 0)
			{
				$qGenre = $this->addAuteurForIdLivre ( $insertID, $IDAuteur );
				
				$qAuteur = $this->addGenreForIdLivre ( $insertID, $IDGenre );
				
				return 1 + $qGenre + $qAuteur;
			}
			
			return false;
		}
		public function deleteLivre($id)
		{
			if ($this->deleteAuteurByIdLivre ( $id ))
			{
				if ($this->deleteGenreByIdLivre ( $id ))
				{
					
					$ql = $this->db->delete ( 'livre', array (
							'ID' => $id ) );
				}
			}
			
			return ql;
		}
		public function alterLivre($data, $dataGenre, $dataAuteur)
		{
			$id = $data ['id'];
			$where = "ID = " . $id;
			
			/* Mise à jour des genres */
			deleteGenreByIdLivre ( $id );
			addGenreForIdLivre ( $id, $dataGenre );
			
			/* Mise à jour des auteurs */
			deleteAuteurByIdLivre ( $id );
			addAuteurForIdLivre ( $id, $dataAuteur );
			
			/* Mise à jour du livre */
			$sql_data = array (
					'titre',
					'resume',
					'courtResume',
					'IDSite',
					'IDType',
					'IDEditeur' );
			
			foreach ( $sql_data as $k => $r )
			{
				if (array_key_exist ( $k, $data ))
				{
					$sql_data [$k] = $data [$k];
				}
				else
				{
					unset ( $sql_data [$k] );
				}
			}
			
			return $this->db->update ( 'livre', $data, $where );
		}
		public function getTypeList()
		{
			$data = $this->db->get ( "type" )->result ();
			$typeArray = array ();
			
			foreach ( $data as $row )
			{
				$typeArray [$row->ID] = $row->libelle;
			}
			
			return $typeArray;
		}
		public function getEditeurList()
		{
			$data = $this->db->get ( "editeur" )->result ();
			
			$editeurArray = array ();
			
			foreach ( $data as $row )
			{
				$editeurArray [$row->ID] = $row->libelle;
			}
			
			return $editeurArray;
		}
		public function getSiteList()
		{
			$data = $this->db->get ( "site" )->result ();
			
			$siteArray = array ();
			
			foreach ( $data as $row )
			{
				$siteArray [$row->ID] = $row->nom;
			}
			
			return $siteArray;
		}
		public function getGenreList()
		{
			$data = $this->db->get ( "genre" )->result ();
			
			$genreArray = array ();
			
			foreach ( $data as $row )
			{
				$genreArray [$row->ID] = $row->libelle;
			}
			
			return $genreArray;
		}
		public function getGenreListByLivreId($id)
		{
			$data = $this->db->get_where ( "livre_genre", array("IDLivre" => $id ))->result ();
			
			$genreArray = array ();
			
			foreach ( $data as $row )
			{
				$genreArray [$row->IDGenre] = $row->IDGenre;
			}
			
			return $genreArray;
		}
		public function getAuteurList()
		{
			$data = $this->db->get ( "auteur" )->result ();
			
			$auteurArray = array ();
			
			foreach ( $data as $row )
			{
				$auteurArray [$row->ID] = $row->nom . " " . $row->prenom;
			}
			
			return $auteurArray;
		}
		public function getAuteurListByLivreId($id)
		{
			$data = $this->db->get ( "livre_auteur", array("IDLivre" => $id ) )->result ();
			
			$auteurArray = array ();
			
			foreach ( $data as $row )
			{
				$auteurArray [$row->IDAuteur] = $row->IDAuteur;
			}
			
			return $auteurArray;
		}
		private function addGenreForIdLivre($IDLivre, array $IDGenre)
		{
			// Tableau d'insertion
			$dataInsert = array ();
			
			// Remplissage du tableau d'insertion avec les données envoyées
			foreach ( $IDGenre as $genre )
			{
				$dataInsert [] = array (
						'IDLivre' => $IDLivre,
						'IDGenre' => $genre );
			}
			
			// Ajout dans la table des lignes
			$this->db->insert_batch ( 'livre_genre', $dataInsert );
			
			return $this->db->affected_rows ();
		}
		private function addAuteurForIdLivre($IDLivre, array $IDAuteur)
		{
			// Tableau d'insertion
			$dataInsert = array ();
			
			// Remplissage du tableau d'insertion avec les données envoyées
			foreach ( $IDAuteur as $auteur )
			{
				$dataInsert [] = array (
						'IDLivre' => $IDLivre,
						'IDAuteur' => $auteur );
			}
			
			// Ajout dans la table des lignes
			$this->db->insert_batch ( 'livre_auteur', $dataInsert );
			
			return $this->db->affected_rows ();
		}
		private function deleteAuteurByIdLivre($id)
		{
			$this->db->delete ( 'livre_auteur', array (
					'IDLivre' => $id ) );
			return $this->db->affected_rows();
		}
		private function deleteGenreByIdLivre($id)
		{
			$this->db->delete ( 'livre_genre', array (
					'IDLivre' => $id ) );
			
			return $this->db->affected_rows ();
		}
	}
	?>