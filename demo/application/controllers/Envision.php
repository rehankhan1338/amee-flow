<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Envision extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
	 
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='envision_menu';
		$this->data['title']='Envision Step1 : Goals And Outcomes Planning';
		$activity_name = 'envision';
		time_tracking_management_ch($activity_name); 
 	}
	
	public function index(){
		
		$this->data['activity_name']='Overview_Mission_Vision/Goals';
		if(isset($_POST['envision_save'])&& $_POST['envision_save']!=''){
			$this->Envision_mdl->envision_save_action1();
 			$this->session->set_flashdata('success', 'Update Successfully!');	
			redirect('department/envision/action1');
		}
		if(isset($_POST['envision_next'])&& $_POST['envision_next']!=''){
			$this->Envision_mdl->envision_save_action1();
			redirect('department/envision/action2');
		}		
		if(isset($_POST['envision_next_action3'])&& $_POST['envision_next_action3']!=''){
			$this->Envision_mdl->envision_save_action1();
			redirect('department/envision/action3');
		}		
		$this->data['page_title']='Envision Step1 : Goals And Outcomes Planning'; 
		$this->data['action_menu']='1'; 
		$this->data['checklist_detail'] = $this->Envision_mdl->department_checklist_detail_row();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/envision/action1',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 			
	}
	
	
	public function action2(){
	
		$this->data['activity_name']='Learning Outcomes/Objectives';
		if(isset($_POST['envision_previous'])&& $_POST['envision_previous']!=''){
			$this->Envision_mdl->envision_save_action2();	
			redirect('department/envision/action1');
		}
		if(isset($_POST['envision_save'])&& $_POST['envision_save']!=''){
			$this->Envision_mdl->envision_save_action2();
 			$this->session->set_flashdata('success', 'Update Successfully!');	
			redirect('department/envision/action2');
		}
		if(isset($_POST['envision_next'])&& $_POST['envision_next']!=''){
			$this->Envision_mdl->envision_save_action2();
			redirect('department/envision/action3');
		}		
		$this->data['page_title']='Envision Step1 : Goals And Outcomes Planning';
		$this->data['action_menu']='2';  
		$this->data['department_pslos_undergraduate'] = $this->Envision_mdl->department_pslos_undergraduate();
		$this->data['department_pslos_graduate'] = $this->Envision_mdl->department_pslos_graduate();
		$this->data['program_learning_outcomes_data'] = $this->Envision_mdl->program_learning_outcomes();
		$this->data['checklist_detail'] = $this->Envision_mdl->department_checklist_detail_row();
		
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/envision/action2',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 	
	}	
	

// =====----- Department_course -----=====//

	public function add_ugrad_grad_plso_entry(){ $this->Envision_mdl->save_department_pslos(); }
	
	public function edit_ugrad_grad_plso_entry(){ $this->Envision_mdl->edit_ugrad_grad_plso_entry(); }	
	
	public function upload_ungrad_grad_plso(){
		
		$this->data['page_title']='Envision Step1 : Goals And Outcomes Planning';
		$this->data['action_menu']='2';  
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/envision/upload_ungrad_grad_plso',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 	
	}	
	
	public function import_data_review(){
		
  		$this->data['page_title']='Envision Step1 : Goals And Outcomes Planning';
		$this->data['action_menu']='2';
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/envision/import_data_review',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 	
	}	
	
	public function import_data_proposed_soc(){
		$this->Envision_mdl->import_data_proposed_soc();
		redirect('department/envision/action2?tab_id=3');
	}	
		
	public function plso_delete(){		
		$this->Envision_mdl->department_pslos_delete($_GET['id']);
	}
	

	public function action3(){
		$this->data['activity_name']='Core Competencies';
		$this->data['page_title']='Envision Step1 : Goals And Outcomes Planning';
		$this->data['action_menu']='3'; 
		$this->data['department_pslos_undergraduate'] = $this->Envision_mdl->department_pslos_undergraduate();
		$this->data['department_pslos_graduate'] = $this->Envision_mdl->department_pslos_graduate();
		$this->data['program_learning_outcomes_data'] = $this->Envision_mdl->program_learning_outcomes();
		$this->data['core_competency_details']=$this->Core_competency_mdl->core_competency_details();
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/envision/action3',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 	
	}
	
	
	public function assign_core_competency(){
		$this->Envision_mdl->assign_core_competency();
	}
	
	
}