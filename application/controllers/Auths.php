<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Auths extends CI_Controller
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
		$this->load->helper ( 'form' );
		$this->load->model ( 'auths_model' );
	}
	public function index()
	{
		$this->login ();
	}
	public function login()
	{
		$this->load->library ( 'form_validation' );
		
		$this->form_validation->set_rules ( 'user', 'Nom d\'utilisateur', 'required' );
		$this->form_validation->set_rules ( 'passwd', 'Mot de passe', 'required' );
		
		$data ['user'] = $data = array (
				'type' => 'input',
				'name' => 'user',
				'id' => 'user',
				'value' => $this->input->post ( 'user' ),
				'placeholder' => 'Nom d\'utilisateur',
				'class' => 'form-control' );
		
		$data ['passwd'] = array (
				'name' => 'passwd',
				'id' => 'passwd',
				'value' => $this->input->post ( 'passwd' ),
				'placeholder' => 'Mot de passe',
				'class' => 'form-control',
				'aria-describedby' => 'passwordHelpBlock' );
		
		if ($this->form_validation->run () === TRUE)
		{
			$data_user = $this->auths_model->getUtilisateur ( $this->input->post ( 'user' ) );
			$log_error = FALSE;
			
			if ($data_user->num_rows ())
			{
				$data_user = $data_user->row_array ();
				// On hash le mot de passe avant verification
				//
				// comparaison entre le mdp bdd et celui entré par l'utilisateur
				if ($this->input->post ( 'passwd' ) === $data_user['motDePasse'])
				{
					unset($data_user['motDePasse']);
					$this->session->set_userdata($data_user);
					
					redirect ( '/welcome/' );
				}
				else
				{
					$log_error = TRUE;
				}
			}
			else
			{
				$log_error = TRUE;
			}
			
			if ($log_error)
			{
				$data ["error_message"] = "La combinaison nom d'utilisateur / mot de passe est incorrect";
			}
		}
		$data ["title"] = "Connexion";
		$this->load->view ( 'templates/header', $data );
		$this->load->view ( 'auths/login', $data );
		$this->load->view ( 'templates/footer' );
	}
	public function logout()
	{
		$this->session->sess_destroy();
		
		$data ["title"] = "Déconnexion réussie";
		$this->load->view ( 'templates/header', $data );
		$this->load->view ( 'auths/success' );
		$this->load->view ( 'templates/footer' );
		
		$this->output->set_header('refresh:5; url='.base_url());
	}
}
