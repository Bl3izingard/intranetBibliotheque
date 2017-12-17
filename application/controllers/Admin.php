<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct ();
		
		if($this->session->userdata('IDUtilisateur') == NULL)
		{
			redirect ( 'auths' );
		}
		
		$this->load->model ( 'admin_model');
		$this->load->model ( 'admin_model' );
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
			$data ['listeEmploye'] = $this->admin_model->getListeEmployeByWhere ( $this->input->post ( 'field' ), $this->input->post ( 'search' ) );
		}
		else
		{
			$data ['listeEmploye'] = $this->admin_model->getListeEmploye ();
		}
		
		$data ['title'] = 'Liste des membres';
		
		$this->load->view ( 'templates/header', $data );
		$this->load->view ( 'admin/liste', $data );
		$this->load->view ( 'templates/footer' );
	}
	public function modifier($id)
	{
		/* Récupération des données */
		$dataUser = $this->admin_model->getEmployeById ( $id )->row ();
		
		$data ['title'] = 'Modifier un employe';
		
		/* Error délimiteur */
		$this->form_validation->set_error_delimiters ( '<div class="form-control-feedback">', '</div>' );
		
		/* Règles de validation */
		$this->form_validation->set_rules ( 'nom', 'Nom d\'utilisateur', 'required' );
		$this->form_validation->set_rules ( 'motDePasse', 'Mot de Passe', 'required|min_length[8]' );
		
		
		/* Champs du formulaire */
		
		$data ['id'] = $id;
		
		$data ['nom'] = array (
				'type' => 'input',
				'name' => 'nom',
				'id' => 'nom',
				'value' => $this->input->post ( 'nom' ),
				'placeholder' => 'Nom d\'utilisateur',
				'class' => 'form-control' );
		
		$data ['motDePasse'] = array (
				'type' => 'password',
				'name' => 'motDePasse',
				'id' => 'motDePasse',
				'value' => $this->input->post ( 'motDePasse' ),
				'placeholder' => 'Mot de passe',
				'class' => 'form-control' );
		
		$data ['responsable'] = $this->admin_model->getResponsableList ();
		
		$data ['user'] = $this->admin_model->getNewUserList ();
		
		$this->load->view ( 'templates/header', $data );
		
		if ($this->form_validation->run () === FALSE)
		{
			$this->load->view ( 'admin/modifier', $data );
		}
		else
		{
			$dataUser = $this->input->post ();
			
			if ($this->admin_model->alterEmploye ( $dataUser ))
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
			if ($this->admin_model->deleteEmploye ( $id ))
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
			$dataUser = $this->admin_model->getEmployeById ( $id );
			
			$data ['title'] = 'Supprimer un membre';
			$data ['user'] = $dataUser->row ();
			
			$this->load->view ( 'templates/header', $data );
			$this->load->view ( 'admin/supprimer', $data );
			$this->load->view ( 'templates/footer' );
		}
	}
	public function ajouter()
	{
		/* Error délimiteur */
		$this->form_validation->set_error_delimiters ( '<div class="form-control-feedback">', '</div>' );
		
		/* Règles de validation */
		$this->form_validation->set_rules ( 'nom', 'Nom d\'utilisateur', 'required' );
		$this->form_validation->set_rules ( 'motDePasse', 'Mot de Passe', 'required|min_length[8]' );
		
		$data ['title'] = 'Ajouter un membre';
		
		/* Champs du formulaire */
		
		$data ['nom'] = array (
				'type' => 'input',
				'name' => 'nom',
				'id' => 'nom',
				'value' => $this->input->post ( 'nom' ),
				'placeholder' => 'Nom d\'utilisateur',
				'class' => 'form-control' );
		
		$data ['motDePasse'] = array (
				'type' => 'password',
				'name' => 'motDePasse',
				'id' => 'motDePasse',
				'value' => $this->input->post ( 'motDePasse' ),
				'placeholder' => 'Mot de passe',
				'class' => 'form-control' );
		
		$data ['responsable'] = $this->admin_model->getResponsableList ();
		
		$data ['utilisateur'] = $this->admin_model->getNewUserList ();
		
		$this->load->view ( 'templates/header', $data );
		
		if ($this->form_validation->run () === FALSE)
		{
			$this->load->view ( 'admin/ajout', $data );
		}
		else
		{
			$dataUser = $this->input->post ();
			
			if ($this->admin_model->addEmploye ( $dataUser ['nom'], $dataUser ['motDePasse']))
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
	public function success()
	{
		$data ['title'] = "";
		$this->load->view ( 'templates/header', $data );
		$this->load->view ( 'sys/success', $data );
		$this->load->view ( 'templates/footer' );
	}
	public function failed()
	{
		$data ['title'] = "";
		$this->load->view ( 'templates/header', $data );
		$this->load->view ( 'sys/failed', $data );
		$this->load->view ( 'templates/footer' );
	}
}