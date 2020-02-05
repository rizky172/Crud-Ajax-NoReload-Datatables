<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH."controllers/CommonDash.php");
class Home extends CommonDash {

	function __construct(){
		parent::__construct();
		$this->load->model('Mod_crud');
	}

	function index(){
		$data = array(
			'_JS' => generate_js(array(	
					"dashboards/js/plugins/validation/validate.min.js",
					"dashboards/js/plugins/bootstrap.bundle.min.js",
					"dashboards/js/plugins/datatables/jquery.dataTables.js",
					"dashboards/js/pages/home-index.js"
				)
			),
			'titleWeb' 		=> "Home",
			'action'		=> site_url('home/form'),
			'breadcrumb'	=> 'Table Home'
		);
		$this->render('dashboard','pages/home/index', $data);
	}

	function table(){
		$list=$this->Mod_crud->get_datatables();
		$data=array();
		$no = $_POST['start'];
		foreach ($list as $key) {
			$url = 'home/form';
			$id = $row[] = $key->id;
			$act = 'edit';
            $no++;
			$row = array();
			$row[] = $no;
			$row[] = $key->nama;
			$row[] = $key->buy;
			$row[] = $key->sale;
			$row[] = $key->qty;
			$row[] = '
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
						<i class="fa fa-cog"></i>
					</button>
					<div class="dropdown-menu">
						<button class="dropdown-item" 
							onclick="showModal('."'".$url."'".','."'".$id."'".','."'".$act."'".')"> 
							<i class="fa fa-edit"></i> Edit
						</button>
						<button class="dropdown-item" 
							id="delete" data-id="'.$id.'"> <i class="fa fa-trash"></i> Delete
						</button>
					</div>
				</div>
			';
			$data[] = $row;
		}
		$result = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Mod_crud->count_all('barang'),
            "recordsFiltered" => $this->Mod_crud->count_filtered(),
			'data' => $data
		);
        echo json_encode($result);
	}
	
	function form(){
		$id =$this->input->post('id');
		$data = array(
			'title'		=> 'Tambah Data',
			'action'	=> site_url('home/save')
		);
		if($id){
			$data = array(
				'title'		=> 'Edit Data',
				'action'	=> site_url('home/update'),
				'data' => $this->Mod_crud->getData('row','*','barang', null, null, null,  array('id = "'.$id[0].'"'))
			);
		}
		// print_r($data);
		$this->load->view('pages/home/form', $data);
	}

	function save(){
		$cek = $this->Mod_crud->checkData('nama', 'barang', array('nama = "'.$this->input->post('nama').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'Nama '.$this->input->post('nama').' has been registered'));
		}else{
			$save = $this->Mod_crud->insertData('barang', 
				array(
					'nama' 		=> $this->input->post('nama'),
					'buy' 		=> $this->input->post('buy'),
					'sale' 		=> $this->input->post('sale'),
					'qty' 		=> $this->input->post('qty')
				)
			);
			if ($save) {
				echo json_encode(array('code' => 200, 'message' => 'Data Has ben Saved'));
			}else{
				echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data'));
			}
		}
	}

	function update($id){
		$update = $this->Mod_crud->updateData('barang', 
			array(
				'nama' 		=> $this->input->post('nama'),
				'buy' 		=> $this->input->post('buy'),
				'sale' 		=> $this->input->post('sale'),
				'qty' 		=> $this->input->post('qty')	
			),
			array('id ' => $id)
		);
		if ($update) {
			echo json_encode(array('code' => 200, 'message' => 'Data Has ben Saved'));
		}else{
			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data'));
		}
	}

	function delete($id){
		$delete = $this->Mod_crud->deleteData('barang', array('id' => $id));
		if ($delete) {
			echo json_encode(array('code' => 200, 'message' => 'Data Has ben Delete'));
		}else{
			echo json_encode(array('code' => 500, 'message' => 'An error occurred while delete data'));
		}
	}
}
