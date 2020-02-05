<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommonDash extends CI_Controller {

	public $data = array();
	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('userlog')['is_login'] == FALSE) :
			redirect(base_url('auth/login')) ;
		endif;
		$this->load->model('Mod_crud');
	}
	public function render($template, $view, $dt)
	{
		$data = array_merge($dt, array(
				'sidebar' => 'nothing',
				)
		);
		$this->template->load($template, $view, $data);
	}
}

/* End of file CommonDash.php */
/* Location: ./application/controllers/CommonDash.php */