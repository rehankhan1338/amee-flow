<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_template extends CI_Controller {
 	 
	function __construct(){
 
		parent::__construct();
		$this->load->helper('adminlogin');
		checkIfLoggedIn($this->session->userdata('userid'));
		$this->data['session_details'] = $this->Login_mdl->adminlogin_details($this->session->userdata('userid'));
		$this->data['university_details'] = $this->Master_helper_mdl->get_university_details($this->config->item('cv_university_id'));
		$this->data['admin_type']=$this->data['session_details']->admin_type;
 		$this->data['success_msg']=$this->session->flashdata('success');
		$this->data['error_msg']=$this->session->flashdata('error');
		$this->data['title']='Category | Administrator Panel';
		$this->data['active_class']='survey_template_menu';   
 	}
	
	public function index(){		
		$this->data['page_title']='Survey Template';
		$this->data['survey_templates_details']=$this->Survey_template_mdl->survey_templates_details();
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/survey_template/list',$this->data);
		$this->load->view('Backend/includes/footer');
	}
	
	public function add(){
		$this->form_validation->set_rules('txt_name','Name','required');	 
		
		if($this->form_validation->run() == FALSE){ 		
			$this->data['page_title']='Survey Template : : Add'; 
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/survey_template/add',$this->data);
			$this->load->view('Backend/includes/footer');		
		}else{		
			$this->Survey_template_mdl->add_survey_templates();
			redirect('admin/survey_template');
		}			
	}
	
	public function edit(){		
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->form_validation->set_rules('txt_name','Name','required');	 
		
		if($this->form_validation->run() == FALSE){ 		
			$this->data['page_title']='Survey Template : : Edit';
			$this->data['survey_templates_details'] = $this->Survey_template_mdl->survey_templates_fulldetails($id);
			$this->load->view('Backend/includes/header',$this->data);
			$this->load->view('Backend/survey_template/edit',$this->data);
			$this->load->view('Backend/includes/footer');		
		}else{		
			$this->Survey_template_mdl->edit_survey_templates($id);
			redirect('admin/survey_template');
		}			
 	}
	
	public function delete(){		
		$this->Survey_template_mdl->delete_survey_templates($_GET['id']);
		redirect('admin/survey_template');
	}
		
//----------------------------------------------------------------------
	
	public function questions(){	
		$last = $this->uri->total_segments();
		$survey_template_id = $this->uri->segment($last);
		$this->data['page_title']='Survey Template : : Questions';
		$this->data['survey_templates_details'] = $this->Survey_template_mdl->survey_templates_fulldetails($survey_template_id);
		$this->data['survey_questions_details'] = $this->Survey_template_mdl->default_surveys_questions_detail($survey_template_id);
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/survey_template/questions_listing',$this->data);
		$this->load->view('Backend/includes/footer');		
	}	
	
	public function add_question(){	
		$last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
		
		$this->data['page_title']='Survey Template : : Add Question';
		$this->data['survey_templates_details'] = $this->Survey_template_mdl->survey_templates_fulldetails($id);
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/survey_template/add_question',$this->data);
		$this->load->view('Backend/includes/footer');		
	}
		
	public function question_save(){
		$survey_id = $this->input->post('hidden_survey_id');
		if(isset($survey_id) && $survey_id!=''){
			$this->Survey_template_mdl->question_save($survey_id);
		}
		redirect(base_url().'admin/survey_template/questions/'.$survey_id);
	}	
	
	public function get_default_question_choice(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			return $this->load->view('Backend/survey_template/default_choices',$this->ajax_data);
		}
	}
	
	public function get_action_html_of_answer(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			return $this->load->view('Backend/survey_template/anser_actions',$this->ajax_data);
		}
	}
	
	
	public function get_default_question_choice_edit(){
		if(isset($_GET['question_type']) && $_GET['question_type']!=''){
			$this->ajax_data['question_type']=$_GET['question_type'];
			$this->ajax_data['default_questions_row'] = $this->Survey_template_mdl->default_surveys_questions_row($_GET['question_type']);
			$this->ajax_data['default_question_answers_detail'] = $this->Survey_template_mdl->default_survey_question_answers_detail($_GET['question_type']);
			return $this->load->view('Backend/survey_template/default_choices_edit',$this->ajax_data);
		}
	}

	public function edit_question(){	
		$last = $this->uri->total_segments();
		$question_id = $this->uri->segment($last);
		$this->data['default_questions_row'] = $this->Survey_template_mdl->default_surveys_questions_row($question_id);
		$survey_templates_id = $this->data['default_questions_row']->survey_id; // survey_id is a survey_templates_id;

		$this->data['page_title']='Survey Template : : Edit Question';
		$this->data['survey_templates_details'] = $this->Survey_template_mdl->survey_templates_fulldetails($survey_templates_id);
		$this->load->view('Backend/includes/header',$this->data);
		$this->load->view('Backend/survey_template/edit_question',$this->data);
		$this->load->view('Backend/includes/footer');		
	}

	
	
	

} 