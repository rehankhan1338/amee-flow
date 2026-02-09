<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logic_models extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		$this->data['university_details'] = $this->Master_helper_mdl->get_university_details($this->config->item('cv_university_id')); 
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Logic Models | Administrator Panel';
		$this->data['active_class']='logic_model_menu';  
		$this->load->model('Logic_model_mdl'); 
 	}	
	
	public function index(){		
		$this->data['page_title']='Logic Models';
		$this->data['logic_model_data'] = $this->Logic_model_mdl->admin_logic_models_list();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/logic_model/list',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function view(){
		$encryptModelId = $this->uri->segment(4);
		$this->data['logic_model_details'] = $this->Logic_model_mdl->get_logic_model_details($encryptModelId); 
		//$modelId = $this->data['logic_model_details']->modelId;
		//$this->data['get_logic_model_step_data'] = $this->Logic_model_mdl->get_logic_model_step_data($modelId); 	
		$this->data['page_title']=$this->data['logic_model_details']->programName.' '.$this->data['logic_model_details']->programYear.' - Logic Model';				
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/logic_model/view',$this->data);
		$this->load->view('Backend/includes/footer',$this->data); 		
	}
	
}