<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Logic_model extends CI_Controller {
 	 
	function __construct(){
		parent::__construct();
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='logic_model_menu';
		$this->data['title']='Logic Model'; 
		$this->load->model('Logic_model_mdl');
		$activity_name = 'logic_model';
		time_tracking_management_ch($activity_name);
 	}
	
	public function index(){
		$this->data['my_logic_model_data'] = $this->Logic_model_mdl->my_logic_model_data($this->session->userdata('dept_id'));	
		$this->data['page_title']='';				
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/logic_model/viewall',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 		
	}
	
	public function view(){
		$encryptModelId = $this->uri->segment(3);
		$this->data['logic_model_details'] = $this->Logic_model_mdl->get_logic_model_details($encryptModelId); 
		//$modelId = $this->data['logic_model_details']->modelId;
		//$this->data['get_logic_model_step_data'] = $this->Logic_model_mdl->get_logic_model_step_data($modelId); 	
		$this->data['page_title']=$this->data['logic_model_details']->programName.' '.$this->data['logic_model_details']->programYear.' - Logic Model';				
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/logic_model/latest',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 		
	}
	
	public function create(){
		$count_created_logic_models = $this->Logic_model_mdl->count_created_logic_models($this->session->userdata('dept_id'));
		if($count_created_logic_models<=2){
			$this->data['activity_name']='Overview';
			$this->data['page_title']='Develop Your Logic Model';			
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/logic_model/manage',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data); 			
		}else{
			$this->session->set_flashdata('error', 'Your logic model develop limit is reached!');	
			redirect(base_url().'logic_model');
		}
	}
	
	public function save_entry(){
		$dept_id = $this->session->userdata('dept_id');
		$this->Logic_model_mdl->save_model_data($dept_id);
		echo 'success';
	}	
	
	public function edit(){
		$encryptModelId = $this->uri->segment(3);
		if(isset($encryptModelId) && $encryptModelId!=''){
			$this->data['logic_model_details'] = $this->Logic_model_mdl->get_logic_model_details($encryptModelId); 
			//$modelId = $this->data['logic_model_details']->modelId;
			//$this->data['get_logic_model_step_data'] = $this->Logic_model_mdl->get_logic_model_step_data($modelId); 
			//echo '<pre>';print_r($this->data['get_logic_model_step_data']);die;		
			$this->data['activity_name']='Overview';
			$this->data['page_title']='Develop Your Logic Model';			
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/logic_model/manage',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data); 			
		}else{
			redirect(base_url().'logic_model');
		}
	}
	
	public function delete(){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$this->Logic_model_mdl->delete_model($_GET['id']);
		}
		redirect(base_url().'logic_model');
	}
	
}