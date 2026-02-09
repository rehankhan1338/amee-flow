<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Light extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error'); 
		$this->data['title']='Login'; 
		$this->load->model('Backend/Accounts_mdl');
		$this->load->model('Users_mdl');
		$this->load->model('Forgot_password_mdl');
 	}

    public function permission(){
		$uaeId = $this->uri->segment(3);
		if(isset($uaeId) && $uaeId!=''){
			$this->Users_mdl->chkLightAccessPermission($uaeId);
		}
	}
 

    public function checkLogin(){
		echo $this->Users_mdl->checkLogin(); 
	}

}