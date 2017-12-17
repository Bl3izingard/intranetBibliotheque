<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Comptes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct ();
		
		if($this->session->userdata('IDUtilisateur') == NULL)
		{
			redirect ( 'auths' );
		}
		
		$this->load->model ( 'comptes_model' );
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
			$data ['listeComptes'] = $this->comptes_model->getListeCompteByWhere ( $this->input->post ( 'field' ), $this->input->post ( 'search' ) );
		}
		else
		{
			$data ['listeComptes'] = $this->comptes_model->getListeCompte ();
		}
		
		$data ['title'] = 'Liste des membres';
		
		$this->load->view ( 'templates/header', $data );
		$this->load->view ( 'comptes/liste', $data );
		$this->load->view ( 'templates/footer' );
	}
	public function modifier($id)
	{
		/* Récupération des données */
		$dataUser = $this->comptes_model->getCompteById ( $id )->row ();
		
		$data ['title'] = 'Modifier un membre';
		
		/* Error délimiteur */
		$this->form_validation->set_error_delimiters ( '<div class="form-control-feedback">', '</div>' );
		
		/* Règles de validation */
		$this->form_validation->set_rules ( 'nom', 'Nom', 'required' );
		$this->form_validation->set_rules ( 'prenom', 'Prénom', 'required' );
		$this->form_validation->set_rules ( 'adresse', 'Adresse', 'required' );
		$this->form_validation->set_rules ( 'mail', 'E-mail', 'required|valid_email' );
		$this->form_validation->set_rules ( 'telephone', 'Téléphone', 'required|exact_length[10]|integer' );
		
		$data ['title'] = 'Ajouter un membre';
		
		/* Champs du formulaire */
		
		$data ['id'] = $id;
		
		$data ['civilite'] = (! empty ( $this->input->post ( 'civilite' ) )) ? $this->input->post ( 'civilite' ) : $dataUser->civilite;
		
		$data ['nom'] = array (
				'type' => 'input',
				'name' => 'nom',
				'id' => 'nom',
				'value' => (! empty ( $this->input->post ( 'nom' ) )) ? $this->input->post ( 'nom' ) : $dataUser->nom,
				'placeholder' => 'Nom',
				'class' => 'form-control' );
		
		$data ['prenom'] = array (
				'type' => 'input',
				'name' => 'prenom',
				'id' => 'prenom',
				'value' => (! empty ( $this->input->post ( 'prenom' ) )) ? $this->input->post ( 'prenom' ) : $dataUser->prenom,
				'placeholder' => 'Prénom',
				'class' => 'form-control' );
		
		$data ['adresse'] = array (
				'name' => 'adresse',
				'id' => 'adresse',
				'value' => (! empty ( $this->input->post ( 'adresse' ) )) ? $this->input->post ( 'adresse' ) : $dataUser->adresse,
				'placeholder' => 'Adresse postale complète',
				'class' => 'form-control' );
		
		$data ['mail'] = array (
				'type' => 'mail',
				'name' => 'mail',
				'id' => 'mail',
				'value' => (! empty ( $this->input->post ( 'mail' ) )) ? $this->input->post ( 'mail' ) : $dataUser->mail,
				'placeholder' => 'Adresse e-mail',
				'class' => 'form-control' );
		
		$data ['telephone'] = array (
				'type' => 'input',
				'name' => 'telephone',
				'id' => 'telephone',
				'value' => (! empty ( $this->input->post ( 'telephone' ) )) ? $this->input->post ( 'telephone' ) : $dataUser->telephone,
				'placeholder' => 'Téléphone',
				'class' => 'form-control' );
		
		$this->load->view ( 'templates/header', $data );
		
		if ($this->form_validation->run () === FALSE)
		{
			$this->load->view ( 'comptes/modifier', $data );
		}
		else
		{
			$dataUser = $this->input->post ();
			
			if ($this->comptes_model->alterCompte ( $dataUser ))
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
			if ($this->comptes_model->deleteCompte ( $id ))
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
			$dataUser = $this->comptes_model->getCompteById ( $id );
			
			$data ['title'] = 'Supprimer un membre';
			$data ['user'] = $dataUser->row ();
			
			$this->load->view ( 'templates/header', $data );
			$this->load->view ( 'comptes/supprimer', $data );
			$this->load->view ( 'templates/footer' );
		}
	}
	public function ajouter()
	{
		/* Error délimiteur */
		$this->form_validation->set_error_delimiters ( '<div class="form-control-feedback">', '</div>' );
		
		/* Règles de validation */
		$this->form_validation->set_rules ( 'nom', 'Nom', 'required' );
		$this->form_validation->set_rules ( 'prenom', 'Prénom', 'required' );
		$this->form_validation->set_rules ( 'adresse', 'Adresse', 'required' );
		$this->form_validation->set_rules ( 'mail', 'E-mail', 'required|valid_email|is_unique[utilisateur.mail]' );
		$this->form_validation->set_rules ( 'telephone', 'Téléphone', 'required|exact_length[10]|integer' );
		
		$data ['title'] = 'Ajouter un membre';
		
		/* Champs du formulaire */
		
		$data ['civilite'] = $this->input->post ( 'civilite' );
		
		$data ['nom'] = array (
				'type' => 'input',
				'name' => 'nom',
				'id' => 'nom',
				'value' => $this->input->post ( 'nom' ),
				'placeholder' => 'Nom',
				'class' => 'form-control' );
		
		$data ['prenom'] = array (
				'type' => 'input',
				'name' => 'prenom',
				'id' => 'prenom',
				'value' => $this->input->post ( 'prenom' ),
				'placeholder' => 'Prénom',
				'class' => 'form-control' );
		
		$data ['civilité'] = array (
				'type' => 'input',
				'name' => 'civilité',
				'id' => 'civilité',
				'value' => $this->input->post ( 'nom' ),
				'class' => 'form-control' );
		
		$data ['adresse'] = array (
				'name' => 'adresse',
				'id' => 'adresse',
				'value' => $this->input->post ( 'adresse' ),
				'placeholder' => 'Adresse postale complète',
				'class' => 'form-control' );
		
		$data ['mail'] = array (
				'type' => 'mail',
				'name' => 'mail',
				'id' => 'mail',
				'value' => $this->input->post ( 'mail' ),
				'placeholder' => 'Adresse e-mail',
				'class' => 'form-control' );
		
		$data ['telephone'] = array (
				'type' => 'input',
				'name' => 'telephone',
				'id' => 'telephone',
				'value' => $this->input->post ( 'telephone' ),
				'placeholder' => 'Téléphone',
				'class' => 'form-control' );
		
		$this->load->view ( 'templates/header', $data );
		
		if ($this->form_validation->run () === FALSE)
		{
			$this->load->view ( 'comptes/ajout', $data );
		}
		else
		{
			$dataUser = $this->input->post ();
			
			if ($this->comptes_model->addCompte ( $dataUser ['nom'], $dataUser ['prenom'], $dataUser ['adresse'], $dataUser ['telephone'], $dataUser ['mail'], $dataUser ['civilite'] ))
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