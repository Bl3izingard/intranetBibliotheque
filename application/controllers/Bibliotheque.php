<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Bibliotheque extends CI_Controller
{
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct ();
		
		if ($this->session->userdata ( 'IDUtilisateur' ) == NULL)
		{
			redirect ( 'auths' );
		}
		$this->load->model ( 'bibliotheque_model' );
		$this->load->helper ( 'url_helper' );
		$this->load->helper ( 'form' );
		$this->load->library ( 'form_validation' );
	}
	public function index()
	{
		$this->liste ();
	}
	public function liste()
	{
		$this->form_validation->set_rules ( 'field', 'Filtre', 'required' );
		$this->form_validation->set_rules ( 'search', 'Champs de recherche' );
		
		if ($this->form_validation->run () === TRUE && ! empty ( $this->input->post ( 'search' ) ))
		{
			$data ['listeLivre'] = $this->bibliotheque_model->getListeLivreByWhere ( $this->input->post ( 'field' ), $this->input->post ( 'search' ) );
		}
		else
		{
			$data ['listeLivre'] = $this->bibliotheque_model->getListeLivre ();
		}
		
		$data ['title'] = 'Liste des Livres';
		
		$this->load->view ( 'templates/header', $data );
		$this->load->view ( 'bibliotheque/liste', $data );
		$this->load->view ( 'templates/footer' );
	}
	public function ajouter()
	{
		/* Error délimiteur */
		$this->form_validation->set_error_delimiters ( '<div class="form-control-feedback">', '</div>' );
		
		/* Règles de validation */
		$this->form_validation->set_rules ( 'titre', 'Titre', 'required' );
		$this->form_validation->set_rules ( 'resume', 'Résume', 'required' );
		$this->form_validation->set_rules ( 'courtResume', 'Court Résumé', 'required|max_length[255]' );
		$this->form_validation->set_rules ( 'genre', 'Genre', '' );
		$this->form_validation->set_rules ( 'auteur', 'Auteur', '' );
		
		$data ['title'] = 'Ajouter un livre';
		
		/* Champs du formulaire */
		
		$data ['titre'] = array (
				'type' => 'titre',
				'name' => 'titre',
				'id' => 'titre',
				'value' => $this->input->post ( 'titre' ),
				'placeholder' => 'Titre',
				'class' => 'form-control' );
		
		$data ['resume'] = array (
				'name' => 'resume',
				'id' => 'resume',
				'value' => $this->input->post ( 'resume' ),
				'placeholder' => 'Résume',
				'class' => 'form-control' );
		
		$data ['courtResume'] = array (
				'name' => 'courtResume',
				'id' => 'courtResume',
				'value' => $this->input->post ( 'courtResume' ),
				'class' => 'form-control' );
		
		$data ['type'] = $this->bibliotheque_model->getTypeList ();
		
		$data ['editeur'] = $this->bibliotheque_model->getEditeurList ();
		
		$data ['site'] = $this->bibliotheque_model->getSiteList ();
		
		$genre = $this->bibliotheque_model->getGenreList ();
		
		foreach ( $genre as $k => $v )
		{
			$data ['genre'] [$v] = array (
					'name' => 'genre[]',
					'id' => 'genre',
					'value' => $k,
					'checked' => ($this->input->post ( 'genre[]' ) != null) ? in_array ( $k, $this->input->post ( 'genre[]' ) ) : FALSE,
					'class' => 'form-control' );
		}
		
		$auteur = $this->bibliotheque_model->getAuteurList ();
		
		foreach ( $auteur as $k => $v )
		{
			$data ['auteur'] [$v] = array (
					'name' => 'auteur[]',
					'id' => 'auteur',
					'value' => $k,
					'checked' => ($this->input->post ( 'auteur[]' ) != null) ? in_array ( $k, $this->input->post ( 'auteur[]' ) ) : FALSE,
					'class' => 'form-control' );
		}
		
		$this->load->view ( 'templates/header', $data );
		
		if ($this->form_validation->run () === FALSE)
		{
			$this->load->view ( 'bibliotheque/ajout', $data );
		}
		else
		{
			$dataUser = $this->input->post ();
			
			if ($this->bibliotheque_model->addLivre ( $dataUser ['titre'], $dataUser ['resume'], $dataUser ['courtResume'], $dataUser ['site'], $dataUser ['type'], $dataUser ['editeur'], $dataUser ['genre'], $dataUser ['auteur'] ))
			{
				redirect ( 'sys/success' );
			}
			else
			{
				redirect ( 'sys/failed' );
			}
		}
		
		$this->load->view ( 'templates/footer' );
	}
	public function modifier($id)
	{
		/* Récupération des données */
		$dataSql = $this->bibliotheque_model->getLivreById ( $id );
		$dataLivre = $dataSql->row ();
		
		$dataGenre = $this->bibliotheque_model->getGenreListByLivreId ( $id );
		$dataAuteur = $this->bibliotheque_model->getAuteurListByLivreId ( $id );
		
		/* Error délimiteur */
		$this->form_validation->set_error_delimiters ( '<div class="form-control-feedback">', '</div>' );
		
		/* Règles de validation */
		$this->form_validation->set_rules ( 'titre', 'Titre', 'required' );
		$this->form_validation->set_rules ( 'resume', 'Résume', 'required' );
		$this->form_validation->set_rules ( 'courtResume', 'Court Résumé', 'required|max_length[255]' );
		$this->form_validation->set_rules ( 'genre', 'Genre', '' );
		$this->form_validation->set_rules ( 'auteur', 'Auteur', '' );
		
		$data ['title'] = 'Modifier un livre';
		
		/* Champs du formulaire */
		$data ['id'] = $id;
		
		$data ['titre'] = array (
				'type' => 'titre',
				'name' => 'titre',
				'id' => 'titre',
				'value' => (! empty ( $this->input->post ( 'titre' ) )) ? $this->input->post ( 'titre' ) : $dataLivre->titre,
				'placeholder' => 'Titre',
				'class' => 'form-control' );
		
		$data ['resume'] = array (
				'name' => 'resume',
				'id' => 'resume',
				'value' => (! empty ( $this->input->post ( 'resume' ) )) ? $this->input->post ( 'resume' ) : $dataLivre->resume,
				'placeholder' => 'Résume',
				'class' => 'form-control' );
		
		$data ['courtResume'] = array (
				'name' => 'courtResume',
				'id' => 'courtResume',
				'value' => (! empty ( $this->input->post ( 'courtResume' ) )) ? $this->input->post ( 'courtResume' ) : $dataLivre->courtResume,
				'class' => 'form-control' );
		
		$data ['type'] = $this->bibliotheque_model->getTypeList ();
		
		$data ['editeur'] = $this->bibliotheque_model->getEditeurList ();
		
		$data ['site'] = $this->bibliotheque_model->getSiteList ();
		
		$genre = $this->bibliotheque_model->getGenreList ();
		
		foreach ( $genre as $k => $v )
		{
			$data ['genre'] [$v] = array (
					'name' => 'genre[]',
					'id' => 'genre',
					'value' => $k,
					'checked' => ($this->input->post ( 'genre[]' ) != null) ? in_array ( $k, $this->input->post ( 'genre[]' ) ) : in_array ( $k, $dataGenre ),
					'class' => 'form-control' );
		}
		
		$auteur = $this->bibliotheque_model->getAuteurList ();
		
		foreach ( $auteur as $k => $v )
		{
			$data ['auteur'] [$v] = array (
					'name' => 'auteur[]',
					'id' => 'auteur',
					'value' => $k,
					'checked' => ($this->input->post ( 'auteur[]' ) != null) ? in_array ( $k, $this->input->post ( 'auteur[]' ) ) : in_array ( $k, $dataAuteur ),
					'class' => 'form-control' );
		}
		
		$this->load->view ( 'templates/header', $data );
		
		if ($this->form_validation->run () === FALSE)
		{
			$this->load->view ( 'bibliotheque/modifier', $data );
		}
		else
		{
			$dataUser = $this->input->post ();
			
			if ($this->bibliotheque_model->alterLivre ( $dataUser, $dataUser ['genre'], $dataUser ['auteur'] ))
			{
				redirect ( 'sys/success' );
			}
			else
			{
				redirect ( 'sys/failed' );
			}
		}
		
		$this->load->view ( 'templates/footer' );
	}
	public function supprimer($id, bool $confirm = FALSE)
	{
		if ($confirm)
		{
			if ($this->bibliotheque_model->deleteLivre ( $id ))
			{
				redirect ( 'sys/success' );
			}
			else
			{
				redirect ( 'sys/failed' );
			}
		}
		else
		{
			$dataLivre = $this->bibliotheque_model->getLivreById ( $id );
			
			$data ['title'] = 'Supprimer un livre';
			$data ['livre'] = $dataLivre->row ();
			
			$this->load->view ( 'templates/header', $data );
			$this->load->view ( 'bibliotheque/supprimer', $data );
			$this->load->view ( 'templates/footer' );
		}
	}
}
