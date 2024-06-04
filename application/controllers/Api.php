<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Mdata');
    }

	public function desa_get($id = null){
		if ($id !== null) {
            $this->form_validation->set_data(array('id' => $id));
            $this->form_validation->set_rules('id', 'id', 'required|integer|greater_than[0]');

            if ($this->form_validation->run() == FALSE) {
                $data_json = array(
                    "status" => REST_Controller::HTTP_BAD_REQUEST,
                    "error" => true,
                    "message" => "ID tidak valid.",
                    "data" => null
                );

                $this->response($data_json, REST_Controller::HTTP_BAD_REQUEST);
                return;
            }
        }
        if ($id === null) {
            $data = $this->Mdata->getAllDesa();
        } else {
            $data = $this->Mdata->getDesaById($id);
        }

		if ($data === null) {
            $data_json = array(
                "status" => REST_Controller::HTTP_NOT_FOUND,
                "error" => true,
                "message" => "Data tidak ditemukan.",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_NOT_FOUND);
        } elseif ($data === false) {
            $data_json = array(
                "status" => REST_Controller::HTTP_INTERNAL_SERVER_ERROR,
                "error" => true,
                "message" => "Server tidak merespons atau terjadi kesalahan dalam memproses permintaan.",
                "data" => null
            );

            $this->response($data_json, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            $data_json = array(
                "status" => REST_Controller::HTTP_OK,
                "error" => false,
                "message" => "Data berhasil diambil.",
                "data" => $data
            );

            $this->response($data_json, REST_Controller::HTTP_OK);
        }
    }

	public function desa_post(){
		$this->form_validation->set_rules('id', 'id', 'required|numeric',
        array(
            'required' => '%s Harus Diisi',
            'numeric' => '%s harus berupa angka'
        ));
        $this->form_validation->set_rules('district_id', 'district_id', 'required|numeric',
        array(
            'required' => '%s Harus Diisi',
            'numeric' => '%s harus berupa angka'
        ));
        $this->form_validation->set_rules('name', 'name', 'required',
        array(
            'required' => '%s Harus Diisi'
        ));

        if($this->form_validation->run() == FALSE){
            $data_json = array(
				"status" => REST_Controller::HTTP_BAD_REQUEST,
                "error" => true,
                "message" => $this->form_validation->error_array()
            );
    
            $this->response($data_json,REST_Controller::HTTP_BAD_REQUEST);
            $this->output->_display();
            exit();
        }

        $data = array(
            "id" => $this->input->post("id"),
            "district_id" => $this->input->post("district_id"),
            "name" => $this->input->post("name"),
        );

		try {
            $result = $this->Mdata->insertDesa($data);

            if ($result) {
                $data_json = array(
					"status" => REST_Controller::HTTP_OK,
					"error" => false,
					"message" => "Data berhasil disimpan.",
					"data" => array(
						"desa" => $result
					)
                );

                $this->response($data_json, REST_Controller::HTTP_OK);
                $this->output->_display();
                exit();
            } else {
                throw new Exception("Gagal menyimpan data.");
            }
        } catch (Exception $e) {
            $data_json = array(
				"status" => REST_Controller::HTTP_INTERNAL_SERVER_ERROR,
                "error" => true,
                "message" => "Terjadi kesalahan saat menyimpan data",
                "data" => $e->getMessage()
            );

            $this->response($data_json, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
	}

    public function desa_put(){
        $validation_message = [];

        if($this->put("district_id")==""){
            array_push($validation_message, "district_id tidak boleh kosong");
        }
        if (!ctype_digit($this->put("district_id"))) {
            array_push($validation_message, "district_id harus berupa angka");
        }
        if($this->put("name")==""){
            array_push($validation_message, "Nama tidak boleh kosong");
        }

        if(count($validation_message)>0){
            $data_json = array(
                "success" => false,
                "message" => "Data tidak valid",
                "data" => $validation_message
            );
    
            $this->response($data_json,REST_Controller::HTTP_OK);
            $this->output->_display();
            exit();
        }

        $data = array(
            "district_id" => $this->put("district_id"),
            "name" => $this->put("name"),
        );

        $id = $this->uri->segment(3);

		try {
            $result = $this->Mdata->updateDesa($data,$id);

            if ($result) {
                $data_json = array(
					"status" => REST_Controller::HTTP_OK,
					"error" => false,
					"message" => "Data berhasil disimpan.",
					"data" => array(
						"desa" => $result
					)
                );

                $this->response($data_json, REST_Controller::HTTP_OK);
                $this->output->_display();
                exit();
            } else {
                throw new Exception("Gagal mengubah data.");
            }
        } catch (Exception $e) {
            $data_json = array(
				"status" => REST_Controller::HTTP_INTERNAL_SERVER_ERROR,
                "error" => true,
                "message" => "Terjadi kesalahan saat menyimpan data",
                "data" => $e->getMessage()
            );

            $this->response($data_json, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function desa_delete(){
        $id = $this->uri->segment(3);
        $desa = $this->Mdata->getDesaById($id);
        if (!$desa) {
            $data_json = array(
                "status" => REST_Controller::HTTP_NOT_FOUND,
                "error" => true,
                "message" => "Data tidak ditemukan.",
                "data" => null
            );
            $this->response($data_json, REST_Controller::HTTP_NOT_FOUND);
            $this->output->_display();
            exit();
        }

        $result = $this->Mdata->deleteDesa($id);
        if ($result) {
            $data_json = array(
                "status" => REST_Controller::HTTP_OK,
                "error" => false,
                "message" => "Data berhasil dihapus.",
                "data" => null
            );
            $this->response($data_json, REST_Controller::HTTP_OK);
        } else {
            $data_json = array(
                "status" => REST_Controller::HTTP_INTERNAL_SERVER_ERROR,
                "error" => true,
                "message" => "Terjadi kesalahan pada server.",
                "data" => null
            );
            $this->response($data_json, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
	
}
