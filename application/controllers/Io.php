<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Io extends CI_Controller
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
		
		$this->load->model ( 'io_model' );
		$this->load->model ( 'auths_model' );
		$this->load->helper ( 'url_helper' );
		$this->load->helper ( 'form' );
		$this->load->library ( 'form_validation' );
	}
	public function index()
	{
		$this->home ();
	}
	public function home()
	{
		$this->form_validation->set_rules ( 'field', 'Filtre', 'required' );
		$this->form_validation->set_rules ( 'search', 'Champs de recherche' );
		
		if ($this->form_validation->run () === TRUE && ! empty ( $this->input->post ( 'search' ) ))
		{
			$data ['listeEmprunt'] = $this->io_model->getEmpruntByWhere ( $this->input->post ( 'field' ), $this->input->post ( 'search' ) );
		}
		else
		{
			$data ['listeEmprunt'] = $this->io_model->getListEmpruntOnly ();
		}
		$data ['dataUser'] = $this->auths_model->getListUser ();
		$data ['title'] = "Emprunt et Retour";
		
		$this->load->view ( 'templates/header', $data );
		$this->load->view ( 'io/liste', $data );
		$this->load->view ( 'templates/footer' );
	}
	public function in($id)
	{
		$data["title"] = "Livre retourné !";
		$this->load->view ( 'templates/header', $data );
		if ($this->io_model->retour ( $id ))
		{
			
			$data ['title'] = "Livre retourné !";
			$this->load->view ( 'io/success', $data );
		}
		else
		{
			redirect ( "sys/failed" );
		}
		
		$this->load->view ( 'templates/footer' );
	}
	public function out()
	{
		$this->form_validation->set_rules ( 'ID', 'Code barre livre', 'required' );
		$this->form_validation->set_rules ( 'user', 'Utilisateur', 'required' );
		
		$data ['title'] = "Emprunter";
		$data ['dataUser'] = $this->auths_model->getListUser ();
		
		$this->load->view ( 'templates/header', $data );
		
		if ($this->form_validation->run () === TRUE)
		{
			if ($this->io_model->getListEmpruntEnCoursByLivreId ( $this->input->post ( 'ID' ) )->num_rows () > 0)
			{
				$data ['erreur'] = "Le livre n'est pas disponible à l'emprunt, veuillez le retourner avant.";
				$this->load->view ( 'io/retour', $data );
			}
			else
			{
				$this->io_model->addEmprunt ( $this->input->post ( 'ID' ), $this->input->post ( 'user' ) );
				$this->load->view ( 'io/success', $data );
			}
		}
		else
		{
			$this->load->view ( 'io/retour', $data );
		}
		$this->load->view ( 'templates/footer' );
	}
}
