<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH."controllers/CommonDash.php");
class Barang extends CommonDash {

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
					"dashboards/js/pages/barang-index.js"
				)
			),
			'titleWeb' 		=> "Barang",
			'action'		=> site_url('barang/form'),
            'breadcrumb'	=> 'Table Barang',
            'data'          => $this->Mod_crud->getData('result','*', 'barang'),
		);
		$this->render('dashboard','pages/barang/index', $data);
	}
	
	function form(){
		$id =$this->input->post('id');
		$data = array(
			'title'		=> 'Tambah Data',
			'action'	=> site_url('barang/save')
		);
		if($id){
			$data = array(
				'title'		=> 'Edit Data',
				'action'	=> site_url('barang/update'),
				'data' => $this->Mod_crud->getData('row','*','barang', null, null, null,  array('id = "'.$id[0].'"'))
			);
		}
		$this->load->view('pages/barang/form', $data);
	}

	function save(){
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

	function update(){
        $id =$this->input->post('id');
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

	function delete(){
        $id =$this->input->post('id');
		$delete = $this->Mod_crud->deleteData('barang', array('id' => $id));
		if ($delete) {
			echo json_encode(
                array(
                    'code' => 200, 
                    'message' => 'Data Has ben Delete',
                    'aksi' => 'setTimeout("window.location.reload();",1500)'
                )
            );
		}else{
			echo json_encode(
                array(
                    'code' => 500, 
                    'message' => 'An error occurred while delete data',
                    'aksi' => 'setTimeout("window.location.reload();",1500)'
                )
            );
		}
	}
}
