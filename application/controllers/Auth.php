<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Mod_crud');
	}

	public function index()
	{
		
	}

	public function login()
	{			
		if ($this->session->userdata('userlog')['is_login'] == TRUE) :
			redirect(base_url('home')) ;
		endif;

		$data = array(
		    'title' => 'Login Page',
		);
		$this->template->load('login', null, $data);
	}

	public function do_login()
	{	
		$cekUser = $this->Mod_crud->getData('row', '*', 'login', null, null, null, array('email = "'.$this->input->post('email').'"'));
		if ($cekUser == false){
			echo json_encode(array('code' => 366, 'message' => 'Email not found'));
		}else{
			$cekPass = $this->Mod_crud->getData('row', '*', 'login', null, null, null, 
			array('email = "'.$this->input->post('email').'"', 'password = "'.MD5($this->input->post('password')).'"'));
			if ($cekPass == false){
				echo json_encode(array('code' => 367, 'message' => 'Wrong password'));
			}else{
				$user = $this->Mod_crud->getData('row', '*', 'login', null, null, null, 
				array('email = "'.$this->input->post('email').'"', 'password = "'.MD5($this->input->post('password')).'"'));
				$login['sess_name']		= $user->nama;
				$login['sess_email'] 	= $user->email;
				$login['sess_role'] 	= $user->role;
				$login['is_login'] 		= TRUE;
				$login['sess_pass'] 	= md5($this->input->post('password'));
				$lokasi = base_url('home');
				$this->session->set_userdata('userlog',$login);
				echo json_encode(array('code' => 200, 'aksi' => "window.location.href = '".$lokasi."'"));
			}
			
		}
	}

	/////////////////////////////////////////////////////////////////////////

	
	public function logout(){
		// helper_log('logout','Logout Application',$this->session->userdata('userlog')['sess_usrID']);

		$this->session->unset_userdata('userlog');
		redirect(base_url('auth/login'));
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */
