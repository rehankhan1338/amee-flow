<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson_plan extends CI_Controller {
 	 
	function __construct(){ 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
		$this->data['university_details'] = $this->Master_helper_mdl->get_university_details($this->config->item('cv_university_id')); 
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Lesson Plans | Administrator Panel';
		$this->data['active_class']='lesson_plan_menu';  
		$this->load->model('Lesson_plan_mdl'); 
 	}	
	
	public function index(){		
		$this->data['page_title']='Lesson Plans';
		$this->data['lesson_plan_data'] = $this->Lesson_plan_mdl->admin_lesson_plans_list();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/lesson_plan/list',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function view(){
		$encryptLessonId = $this->uri->segment(4);
		$this->data['lesson_plan_details'] = $this->Lesson_plan_mdl->get_lesson_plan_details($encryptLessonId); 	
		$this->data['page_title']='Lesson Plan : : '.$this->data['lesson_plan_details']->lessonTitle.' on '.date('d M Y',$this->data['lesson_plan_details']->sessionDate);				
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/lesson_plan/view',$this->data);
		$this->load->view('Backend/includes/footer',$this->data); 		
	}
	
}