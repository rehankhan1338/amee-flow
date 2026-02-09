<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Lesson_plan extends CI_Controller {
 	 
	function __construct(){
		parent::__construct();
		$this->load->helper('departmentlogin');
		checkIfLoggedIn($this->session->userdata('dept_id'));
		$this->data['dept_session_details'] = $this->Auth_mdl->departlogin_details($this->session->userdata('dept_id')); 
		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');  
		$this->data['active_class']='lesson_plan_menu';
		$this->data['title']='Lesson Plan'; 
		$this->load->model('Lesson_plan_mdl');
		$activity_name = 'lesson_plan';
		//time_tracking_management_ch($activity_name);
 	}
	
	public function index(){
		$this->data['my_lesson_plan_data'] = $this->Lesson_plan_mdl->my_lesson_plan_data($this->session->userdata('dept_id'));	
		$this->data['page_title']='';				
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/lesson_plan/viewall',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 		
	}
	
	public function view(){
		$encryptLessonId = $this->uri->segment(3);
		$this->data['lesson_plan_details'] = $this->Lesson_plan_mdl->get_lesson_plan_details($encryptLessonId);  	
		$this->data['page_title']=$this->data['lesson_plan_details']->lessonTitle.' on '.date('d M Y',$this->data['lesson_plan_details']->sessionDate).' - Lesson Plan';			
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/lesson_plan/latest',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data); 		
	}
	
	public function create(){
		$this->data['page_title']='Develop Your Lesson Plan';			
		$this->load->view('Frontend/includes/header',$this->data);
		$this->load->view('Frontend/lesson_plan/manage',$this->data);
		$this->load->view('Frontend/includes/footer',$this->data);
		/*$count_created_lesson_plans = $this->Lesson_plan_mdl->count_created_lesson_plans($this->session->userdata('dept_id'));
		if($count_created_lesson_plans<=2){
			 			
		}else{
			$this->session->set_flashdata('error', 'Your lesson plan develop limit is reached!');	
			redirect(base_url().'lesson_plan');
		}*/
	}
	
	public function save_entry(){
		$dept_id = $this->session->userdata('dept_id');
		$this->Lesson_plan_mdl->save_model_data($dept_id);
		echo 'success';
	}
	
	public function make_clone(){
		if(isset($_GET['ids']) && $_GET['ids']!=''){
			$this->Lesson_plan_mdl->make_clone($_GET['ids']);
		}
		echo 'success';
	}	
  	
	public function delete_plan(){
		if(isset($_GET['ids']) && $_GET['ids']!=''){
			$this->Lesson_plan_mdl->delete_plan($_GET['ids']);
		}
		redirect(base_url().'lesson_plan');
	}
	
	public function edit(){
		$encryptLessonId = $this->uri->segment(3);
		if(isset($encryptLessonId) && $encryptLessonId!=''){
			$this->data['lesson_plan_details'] = $this->Lesson_plan_mdl->get_lesson_plan_details($encryptLessonId);	
			$this->data['page_title']='Develop Your Lesson Plan';			
			$this->load->view('Frontend/includes/header',$this->data);
			$this->load->view('Frontend/lesson_plan/manage',$this->data);
			$this->load->view('Frontend/includes/footer',$this->data); 			
		}else{
			redirect(base_url().'lesson_plan');
		}
	}
	
}