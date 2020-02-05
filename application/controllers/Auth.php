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

		public function reset($token=null)
	{	
		$getreset = $this->Mod_crud->getData('row','*','t_passwordreset',null,null,null,array('tokeN = "'.$token.'"'));
		if ($getreset == false) {
			echo "Link has been Expired !";
		}else{
		$dtmulai = date('Y-m-d H:i:s');
		$dtakhir = $getreset->expired_at;
		if ($dtmulai >= $dtakhir) {
			$delete 	= $this->Mod_crud->deleteData('t_passwordreset',array('tokeN'=>$token));
			echo "Lnik has been Expired !";
		}else{

		$data = array(
		    'titleWeb' 	=> 'Reset Page | CBN Internship',
		    'email'	=> $getreset->emaiL
		);
		$this->template->load('reset', null, $data);
		}
	  }
	}

	public function do_reset()
	{
		$email = $this->input->post('email');
		$pass1 = $this->input->post('pass1');
		$pass2 = $this->input->post('pass2');

		$cekemail = $this->Mod_crud->getData('row', '*', 't_login', null, null, null, array('emaiL = "'.$email.'"'));
		if ($cekemail == false){
			echo json_encode(array('code' => 366, 'message' => 'Email not found !'));
		}else{
			if ($pass1 != $pass2){
				echo json_encode(array('code' => 368, 'message' => 'Password not same !'));
			}else{

				$delete  = $this->Mod_crud->deleteData('t_passwordreset',array('emaiL'=>$email));

				if ($cekemail->roleID == 11 OR $cekemail->roleID == 22) {
					$user 	= $this->Mod_crud->getData('row', '*', 't_admin', null, null, null, array('emaiL = "'.$email.'"'));
					$login['sess_usrID']  = $user->adminID;
					$login['sess_deptID'] = $user->deptID;
					$avatar = base_url('fileupload/pic_admin/default.png');
				}elseif ($cekemail->roleID == 33) {
					$user 	= $this->Mod_crud->getData('row', '*', 't_admin_university', null, null, null, array('emaiL = "'.$email.'"'));
					$login['sess_usrID'] 	= $user->adminCampusID;
					$login['sess_univID'] 	= $user->universityID;
					$avatar = base_url('fileupload/pic_admin/default.png');
				}elseif ($cekemail->roleID == 44) {
					$user 	= $this->Mod_crud->getData('row', '*', 't_dosen', null, null, null, array('emaiL = "'.$email.'"'));
					$login['sess_usrID'] 	= $user->dosenID;
					$login['sess_univID'] 	= $user->universityID;
					$login['sess_facID'] 	= $user->facultyID;
					$avatar = base_url('fileupload/pic_dosen/default.png');
				}else {
					$user 	= $this->Mod_crud->getData('row', '*', 't_mahasiswa', null, null, null, array('emaiL = "'.$email.'"'));
					$login['sess_usrID'] 	= $user->mahasiswaID;
					$login['sess_univID'] 	= $user->universityID;
					$login['sess_facID'] 	= $user->facultyID;
					$avatar = base_url('fileupload/pic_mahasiswa/default.png');
				}

					$login['sess_name']	= $user->fullName;
					$login['sess_email'] 	= $cekemail->emaiL;
					$login['sess_role'] 	= $cekemail->roleID;
					$login['is_login'] 	= TRUE;
					$login['sess_pass'] 	= md5($this->input->post('password'));
					$login['sess_avatar'] 	= $avatar;
				
				$lokasi = base_url('dashboard');
				
				$this->Mod_crud->updateData('t_login', array(
					'passworD' 	=> md5($pass1),
					'statuS'	=> 'verified',
					'lastLog' => date('Y/m/d H:i:s')
					),array('emaiL' => $this->input->post('email'))
				);

				$this->session->set_userdata('userlog',$login);
				helper_log('reset','Success reset password ',$this->session->userdata('userlog')['sess_usrID']);

				$this->alert->set('bg-success', 'Welcome '.$login['sess_name'].', you login as '.what_role($login['sess_role']).' !');
				echo json_encode(array('code' => 200, 'aksi' => "window.location.href = '".$lokasi."'"));
			}
		}
	}

	////////////////////////////////////////////////////////////////////////////
	public function forgot()
	{				
		$data = array(
		    'titleWeb' => 'Forgot Page | CBN Internship',
		);
		$this->template->load('forgot', null, $data);
	}

	public function do_forgot()
	{
		$emaiL 		= $this->input->post('email');

		$delete 	= $this->Mod_crud->deleteData('t_passwordreset',array('emaiL'=>$emaiL));

		$cekemail 	= $this->Mod_crud->getData('row', '*', 't_login', null, null, null, array('emaiL = "'.$emaiL.'"'));

		if ($cekemail == false){
			echo json_encode(array('code' => 366, 'message' => 'Email not found !'));

		}else{

		$set 	= '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$tokeN 	= substr(str_shuffle($set), 0, 55);
		$create = time();
		$exp = 60*60;
		$done = $create+$exp;
		$expired_at = date('Y-m-d H:i:s',$done);

		$t_passwordreset = $this->Mod_crud->insertData('t_passwordreset', array(
				'emaiL'		=> $emaiL,
				'tokeN'		=> $tokeN,
				'created_at'	=> date('Y-m-d H:i:s'),
				'expired_at'	=> $expired_at
				)
			);

		$config = array(
				  		'protocol' => 'ssmtp',
				  		'smtp_host' => 'ssl://mail.intern7.iex.or.id',
				  		'smtp_port' => 465,
				  		'smtp_user' => 'info@intern7.iex.or.id', // change it to yours
				  		'smtp_pass' => 'Infocbn123', // change it to yours
				  		//'smtp_username' => 'armg3295',
				  		'mailtype' => 'html',
				  		'charset' => 'iso-8859-1',
				  		'wordwrap' => TRUE
			);

			$message = 	"
						<html>
						<head>
							<title>Forgot Password</title>
						</head>
						<body>
							<h2>CBN Internship Web Portal</h2>
							<p>Please click the link below to set new password ".base_url('auth/reset/'.$tokeN)." <br/>( warning: this link will expire after one hour )<br/><br/></p>
							<p><hr />Do Not reply to this message<hr /><br/></p>
							<p>CBN Internet<br/>
								PT. Cyberindo Aditama<br/>
								Jalan. HR Rasuna Said Blok X5, No. 13<br/>
								Jakarta Selatan - 12950<br/>
								Telp. (021) 2996-4900<br/>
								Fax : +62 21 574-2481<br/>
								Web : www.cbn.net.id<br/>
							</p>							
						</body>
						</html>
						";
	 		
		    $this->load->library('email', $config);
		    $this->email->set_newline("\r\n");
		    $this->email->from($config['smtp_user']);
		    $this->email->to($emaiL);
		    $this->email->subject('Forgot Password');
		    $this->email->message($message);

		    helper_log('forgot','Send link setup password to '.$emaiL);
		    
		    $lokasi = base_url('auth/login');
           	if ($this->email->send()){
           		$this->alert->set('bg-success', 'Success , your setup link has been send !');
				echo json_encode(array('code' => 200, 'aksi' => "window.location.href = '".$lokasi."'"));
           	}else{
           		$this->alert->set('bg-danger', 'Error, an error while send the link !');
				echo json_encode(array('code' => 200, 'aksi' => "window.location.href = '".$lokasi."'"));           	
        	}
        }
	}

	/////////////////////////////////////////////////////////////////////////////

		public function register()
	{				
		$data = array(
		    'titleWeb' => 'Register Page | CBN Internship',
		);
		$this->template->load('register', null, $data);
	}

		public function getFaculty()
	{
		$resp = array();
		$data = $this->Mod_crud->getData('result', 'facultyID, facultyName', 't_faculty');
		if (!empty($data)) {
			foreach ($data as $key) {
				$mk['id'] = $key->facultyID;
				$mk['text'] = $key->facultyName;
				array_push($resp, $mk);
			}
		}
		echo json_encode($resp);
	}

		public function getUniv()
	{
		$resp = array();
		$data = $this->Mod_crud->getData('result', 'universityID, universityName', 't_university',null,null,null,array('mou = "YES"'));
		if (!empty($data)) {
			foreach ($data as $key) {
				$mk['id'] = $key->universityID;
				$mk['text'] = $key->universityName;
				array_push($resp, $mk);
			}
		}
		echo json_encode($resp);
	}

	public function do_register()
	{
		
		$cekemail = $this->Mod_crud->checkData('emaiL', 't_login', array('emaiL = "'.$this->input->post('Email').'"'));
		if ($cekemail) {
			echo json_encode(array('code' => 366, 'message' => 'Email has been registered'));
		}else{
		$cekmahasiswa = $this->Mod_crud->checkData('mahasiswaNumber', 't_mahasiswa', array('mahasiswaNumber = "'.$this->input->post('Nim').'"'));
		if ($cekmahasiswa) {
			echo json_encode(array('code' => 367, 'message' => 'Your nim has been registered'));
		} else {
			//pic
			$mahasiswaID 	= $this->Mod_crud->autoNumber('mahasiswaID','t_mahasiswa','55',4);
			
				$savemahasiswa 	= $this->Mod_crud->insertData('t_mahasiswa', array(
           				'mahasiswaID'		=> $mahasiswaID,
           				'loginID'		=> $mahasiswaID,
           				'universityID' 		=> $this->input->post('Universityid'),
           				'facultyID' 		=> $this->input->post('Facultyid'),
           				'emaiL'			=> $this->input->post('Email'),
           				'mahasiswaNumber'	=> $this->input->post('Nim'),
           				'fullName' 		=> ucwords($this->input->post('Fullname')),
           				'mobilePhone'		=> $this->input->post('Mobilephone'),
           				'createdBY'		=> 'Register',
           				'createdTIME'		=> date('Y-m-d H:i:s')
           			)
           		);

	           	$savelogin = $this->Mod_crud->insertData('t_login', array(
					'loginID'		=> $mahasiswaID,
					'roleID'		=> 55,
					'emaiL'			=> $this->input->post('Email'),
					'passworD'		=> 'null',
					'statuS'		=> 'new-mahasiswa',
					'createdTime'	=> date('Y-m-d H:i:s')
					)
				);

           		$set 	= '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$tokeN 	= substr(str_shuffle($set), 0, 55);
				$create = time();
				$exp = 60*60;
				$done = $create+$exp;
				$expired_at = date('Y-m-d H:i:s',$done);

				$t_passwordreset = $this->Mod_crud->insertData('t_passwordreset', array(
						'emaiL'		=> $this->input->post('Email'),
						'tokeN'		=> $tokeN,
						'created_at'	=> date('Y-m-d H:i:s'),
						'expired_at'	=> $expired_at
						)
					);

					$config = array(
				  		'protocol' => 'ssmtp',
				  		'smtp_host' => 'ssl://mail.intern7.iex.or.id',
				  		'smtp_port' => 465,
				  		'smtp_user' => 'info@intern7.iex.or.id', // change it to yours
				  		'smtp_pass' => 'Infocbn123', // change it to yours
				  		//'smtp_username' => 'armg3295',
				  		'mailtype' => 'html',
				  		'charset' => 'iso-8859-1',
				  		'wordwrap' => TRUE
					);

					$message = 	"
								<html>
								<head>
									<title>Account Setup Link</title>
								</head>
								<body>
									<h2>CBN Internship Web Portal</h2>
									<p>Please click the link below to set your password ".base_url('auth/reset/'.$tokeN)." <br/>( warning: this link will expire after one hour )<br/><br/></p>
									<p><hr />Do Not reply to this message<hr /><br/></p>
									<p>CBN Internet<br/>
										PT. Cyberindo Aditama<br/>
										Jalan. HR Rasuna Said Blok X5, No. 13<br/>
										Jakarta Selatan - 12950<br/>
										Telp. (021) 2996-4900<br/>
										Fax : +62 21 574-2481<br/>
										Web : www.cbn.net.id<br/>
									</p>							
								</body>
								</html>
								";
			 		
				    $this->load->library('email', $config);
				    $this->email->set_newline("\r\n");
				    $this->email->from($config['smtp_user']);
				    $this->email->to($this->input->post('Email'));
				    $this->email->subject('Account Setup Link');
				    $this->email->message($message);
				    
				    helper_log('register','New application mahasiswa '.$this->input->post('Email'));
		    
			    $lokasi = base_url('auth/login');
	           	if ($this->email->send()){
	           		$this->alert->set('bg-success', 'Register success , Setup link has been send to your email !');
					echo json_encode(array('code' => 200, 'aksi' => "window.location.href = '".$lokasi."'"));
	           	}else{
	           		$this->alert->set('bg-danger', 'Error, an error while saving data !');
					echo json_encode(array('code' => 200, 'aksi' => "window.location.href = '".$lokasi."'"));           	
	        	}
			}
		}
	}
	//////////////////////////////////////////////////////////////////////////////

	public function logout(){
		// helper_log('logout','Logout Application',$this->session->userdata('userlog')['sess_usrID']);

		$this->session->unset_userdata('userlog');
		redirect(base_url('auth/login'));
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */
